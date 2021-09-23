<?php

namespace LinkedDataImporter\CustomerChain;

use LinkedDataImporter\DataStructure\CustomerList;

/**
 * Directly solves the task - builds chains of duplicates
 */
class CustomerChainBuilder
{
    public function build(CustomerList $customerList): CustomerList
    {
        $chainsLinks = $this->buildChainsLinks($customerList);
        $chains = $this->buildChains($chainsLinks);
        $this->linkCustomers($customerList, $chains);

        unset($chainsLinks, $chains);

        return $customerList;
    }

    private function buildChainsLinks(CustomerList $customerList): array
    {
        $chainsLinks = [];
        foreach ($customerList->all() as $customer) {
            $chainsLinks[$customer->getEmail()][] = $customer->getId();
            $chainsLinks[$customer->getCard()][] = $customer->getId();
            $chainsLinks[$customer->getPhone()][] = $customer->getId();
        }

        return $chainsLinks;
    }

    private function buildChains(array &$chainsLinks): array
    {
        $mergesCount = 1;
        while ($mergesCount) {
            $mergesCount = $this->mergeChainsLinks($chainsLinks);
        }

        return array_unique($chainsLinks, SORT_REGULAR);
    }

    public function mergeChainsLinks(array &$chainsLinks): int
    {
        $mergesCount = 0;
        foreach ($chainsLinks as $identifier => $link) {
            $mergesCount += $this->makeLinkMerges($chainsLinks, $identifier, $link);
        }

        return $mergesCount;
    }

    private function makeLinkMerges(array &$chainsLinks, string $identifier, array $link): int
    {
        $mergesCount = 0;
        foreach ($chainsLinks as $comparisonIdentifier => $comparisonLink) {
            if ($identifier === $comparisonIdentifier) {
                continue;
            }
            if ($link === $comparisonLink) {
                continue;
            }

            $intersection = array_intersect($link, $comparisonLink);

            if (empty($intersection)) {
                continue;
            }

            $mergedLinks = array_unique(array_merge($link, $comparisonLink));
            $chainsLinks[$identifier . '-' . $comparisonIdentifier] = $mergedLinks;
            unset($chainsLinks[$identifier], $chainsLinks[$comparisonIdentifier]);
            $mergesCount++;
        }

        return $mergesCount;
    }

    private function linkCustomers(CustomerList $customerList, array $chains): void
    {
        foreach ($customerList->all() as $customer) {
            foreach ($chains as $chain) {
                if (!in_array($customer->getId(), $chain, true)) {
                    continue;
                }
                $customer->setParentId(min($chain));
            }
        }
    }
}