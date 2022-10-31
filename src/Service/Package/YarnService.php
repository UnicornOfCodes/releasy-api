<?php

namespace App\Service\Package;

use App\Entity\Package;
use Symfony\Component\HttpClient\HttpClient;

class YarnService
{
    private $httpClient;
    private $securityUpdates;
    private $npmUrl = "https://registry.npmjs.org/-/npm/v1/security/audits";

    public function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    public function check(Package $package, $information)
    {
        $this->securityUpdates = [];
        $lockFileContent = $this->build(json_decode($information, true));
        $this->securityCheck(json_encode($lockFileContent));
        $this->save($package, $lockFileContent);
    }

    private function build($lockFileContent)
    {
        $requires = [];

        foreach ($lockFileContent['dependencies'] as $key => $dependency) {
            $requires[$key] = $dependency['version'];
        }

        $lockFileContent['requires'] = $requires;

        return $lockFileContent;
    }

    public function securityCheck($lockFileContent)
    {
        $this->securityUpdates = null;
        $response = $this->httpClient->request('POST',
            $this->npmUrl, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $lockFileContent
            ]
        );

        $this->securityUpdates = json_decode($response->getContent(), true);
        return true;
    }

    private function save(Package $package, $lockFileContent)
    {
        $packageSecurityAudit = [];
        foreach ($this->securityUpdates['advisories'] as $securityUpdate) {
            $cvesList = null;

            if (count($securityUpdate['cves']) > 0) {
                foreach ($securityUpdate['cves'] as $cve) {
                    $cvesList .= $cve . " ";
                }
            }
            $version = isset($lockFileContent['requires'][$securityUpdate['module_name']]) ? $lockFileContent['requires'][$securityUpdate['module_name']] : "not defined";

            $packageSecurityAudit[$securityUpdate['module_name']] = [
                "name" => $securityUpdate['module_name'],
                "version" => $version,

                "min-version" => $securityUpdate['patched_versions'],
                "advisories" => [[
                    "title" => $securityUpdate['title'],
                    "severity" => $securityUpdate['severity'],
                    "link"  => $securityUpdate['url'],
                    "cve" => $cvesList
                ]]
            ];

        }
        $package->setSecurity($packageSecurityAudit);
    }

}