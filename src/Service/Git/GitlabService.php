<?php

namespace App\Service\Git;

use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Git;
use App\Entity\Package;
use Symfony\Component\HttpFoundation\Response;

class GitlabService
{
    private $httpClient;
    private $baseApi;

    public function setBaseApi($url)
    {
        $this->baseApi = $url . '/api/v4/';
    }

    public function initHeader($token = null)
    {
        $headers = [];

        if ($token) {
            $headers = ['PRIVATE-TOKEN' => $token];
        }

        $this->httpClient = HttpClient::create(['headers' => $headers]);
    }

    /**
     * This function get all information from GIT 
     *
     * @param Git $git
     * @return void
     */
    public function getInfo(Git $git)
    {
        $this->initHeader($git->getAccessToken());
        $this->setBaseApi($git->getBaseUrl());

        $response = $this->httpClient->request('GET', $this->baseApi . "projects?search=". $git->getRepositoryName());
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $content = json_decode($response->getContent(), true);
            
            $git->setApiId($content[0]['id']);
            $git->setFullUrl($content[0]['web_url']);
        }

        return;
    }

    /**
     * This function get content from package
     *
     * @param Package $package
     * @return void
     */
    public function getPackageInfo(Package $package)
    {
        $git = $package->getGit();
        $this->initHeader($git->getAccessToken());
        $this->setBaseApi($git->getBaseUrl());

        $response = $this->httpClient->request('GET', $this->baseApi . "projects/" . $git->getApiId() . "/repository/files/". urlencode($package->getPath()) . "?ref=" . $git->getBranch());
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $content = json_decode($response->getContent(), true);
            return base64_decode($content['content']);
        }
        return false;
    }

    /**
    * This function return 20 branch name (limit by Api Gitlab)
    * Following this structure
    * [ 
    *  "Unprotected branch" => ['name', 'name2'],
    *  "Protected branch" => ['name3', 'name4']
    * ]
    * 
    *
    * @param Git $git
    * @return void
    */
    public function getBranch(Git $git)
    {
        $this->initHeader($git->getAccessToken());
        $this->setBaseApi($git->getBaseUrl());

        $response = $this->httpClient->request('GET', $this->baseUrl . "projects/" . $git->getApiId() . "/repository/branches");
        $branchName = [];
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $arrays = json_decode($response->getContent(), true);
            foreach ($arrays as $array) {
                $branchName["Unprotected branch"][$array['name']] = $array['name'];
            }
        }
        $response = $this->httpClient->request('GET', $this->baseUrl . "projects/" . $git->getApiId() . "/protected_branches");
        if ($response->getStatusCode() == Response::HTTP_OK) {
            $arrays = json_decode($response->getContent(), true);
            foreach ($arrays as $array) {
                $branchName["Protected branch"][$array['name']] = $array['name'];
            }
        }

        return $branchName;
    }

}
