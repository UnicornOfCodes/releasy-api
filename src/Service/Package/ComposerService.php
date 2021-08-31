<?php

namespace App\Service\Package;

use App\Entity\Package;
use Symfony\Component\Process\Process;

class ComposerService
{
    private $alert;
    private $securityUpdates;

    public function check(Package $package, $information)
    {
        $fileName = 'composer_' . bin2hex(random_bytes(42)) . '.lock';
        $path = __DIR__."/../../../public/$fileName";

        $composerFile = fopen($path, "w");
        fwrite($composerFile, $information);
        $package->setContent(json_decode($information, true)['packages']);

        $this->securityCheck($path);
        $this->save($package);

        fclose($composerFile);
        unlink($path);
    }

    private function securityCheck($path)
    {
        $process = new Process(['/usr/local/bin/symfony', 'local:check:security', '--dir='.$path, '--format=json']);
        $process->run();
        $this->alerts = json_decode((string) $process->getOutput(), true);
    }

    private function save(Package $package)
    {
        $packageSecurityAudit = [];

        if ($this->securityUpdates) {
            foreach ($this->securityUpdates as $key => $securityUpdate) {
                $packageSecurityAudit[$key] = $securityUpdate;
                $packageSecurityAudit[$key]["advisories"] = [];
            }
        }

        if ($this->alerts) {
            foreach ($this->alerts as $key => $alert) {
                $packageSecurityAudit[$key]['advisories'] = $alert['advisories'];
                if (!isset($packageSecurityAudit[$key])) {
                    $packageSecurityAudit[$key] = [];
                }
                if (!isset($packageSecurityAudit[$key]['version'])) {
                    $packageSecurityAudit[$key]["version"] = $alert['version'];
                }
                if (!isset( $packageSecurityAudit[$key]['name'])) {
                    $packageSecurityAudit[$key]['name'] = $key;
                }
            }
        }
        $package->setSecurity($packageSecurityAudit);
    }

}