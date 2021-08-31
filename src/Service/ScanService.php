<?php

namespace App\Service;

use App\Entity\Git;
use App\Entity\Package;
use App\Service\Git\GitlabService;
use App\Service\Package\ComposerService;

class ScanService
{


    public function scan(Package $package)
    {
        $providerService = $this->getProviderService($package->getGit()->getProvider()); 
        $information = $providerService->getPackageInfo($package);

        $packageService = $this->getPackageService($package->getType());

        $packageService->check($package, $information);

        return true;
    }

    private function getPackageService(string $packageType)
    {
        switch ($packageType)
        {
            case Package::TYPE_COMPOSER: 
                return new ComposerService();
        }
    }

    private function getProviderService(string $providerType)
    {
        switch($providerType)
        {
            case Git::PROVIDER_GITLAB: 
                return new GitlabService();
        }
    }
}
