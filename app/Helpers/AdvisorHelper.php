<?php
if (!function_exists('buildTree')) {
    function buildTree(array $elements, int $parentId = null): array
    {
        $branch = [];

        foreach ($elements as $element) {

            if ($element['parent_id'] == $parentId) {

                if (isset($element['login'])) {

                    $children = buildTree($elements, $element['id']);

                    if ($children) {
                        $element['childrens'] = $children;
                    }

                    $advisor_items = [
                        'id' => $element['id'],
                        'rank_id' => $element['rank_id'],
                        'parent_id' => $element['parent_id'],
                        'login' => $element['login'],
                        'childrens' => $children,
                    ];

                    $branch[] = $advisor_items;
                } else {
                    Log::error('Error in helper buildTree()');
                }
            }
        }

        return $branch;
    }
}

if (!function_exists('getPourcentageParrainage')) {
    function getPourcentageParrainage(array $configParrainage, int $parentRank = null): int
    {   
        foreach ($configParrainage as $element) {
            $conf[$element->parent_rank_id] = $element->bonus_percentage;
        }
        if(key_exists($parentRank,$conf)){
            
            return $conf[$parentRank];
        }
        return 0;
    }
}

if (!function_exists('getPourcentageAnimation')) {
    function getPourcentageAnimation(array $configAnimation, int $advisorRank = null, int $childRank = null): int
    {   
        foreach ($configAnimation as $element) {
            $conf[$element->parent_rank_id][$element->advisor_rank_id] = $element->bonus_percentage;
        }
        if(key_exists($advisorRank,$conf) && key_exists($childRank,$conf[$advisorRank]) ){
            
            return $conf[$advisorRank][$childRank];
        }
        return 0;
    }
}

if (!function_exists('getRank')) {
    function getRank(array $advisors, int $advisor_id = null): int
    {   
        foreach ($advisors as $element) {
            $ad[$element["id"]] = $element["rank_id"];
        }
        if(key_exists($advisor_id,$ad)){
            
            return $ad[$advisor_id];
        }
        return 0;
    }
}

if (!function_exists('getNewRank')) {
    function getNewRank(array $configRank, int $amount = null): int
    {   
        foreach($configRank as $config){
            if($amount >= $config->amount){
                $new_rank_id = $config->rank_id;
                return $new_rank_id;
                break;
            }
        }
        return 1;
    }
}