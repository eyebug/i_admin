<?php

class CityModel extends \BaseModel {

    public function getCityList($paramList, $cacheTime = 0) {
        do {
            if ($cacheTime == 0) {
                $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            } else {
                $params['limit'] = 0;
            }
            $isCache = $cacheTime != 0 ? true : false;
            $result = $this->rpcClient->getResultRaw('B002', $params, $isCache, $cacheTime);
        } while (false);
        return (array)$result;
    }

}
