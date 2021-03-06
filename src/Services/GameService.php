<?php


namespace Betsolutions\Casino\SDK\Services;


use Betsolutions\Casino\SDK\DTO\Game\GetGamesResponseContainer;
use Betsolutions\Casino\SDK\Exceptions\CantConnectToServerException;
use Betsolutions\Casino\SDK\Exceptions\JsonMappingException;
use Betsolutions\Casino\SDK\MerchantAuthInfo;

class GameService extends BaseService
{
    public function __construct(MerchantAuthInfo $authInfo)
    {
        parent::__construct($authInfo, 'Game');
    }

    /**
     * @return GetGamesResponseContainer
     * @throws CantConnectToServerException
     * @throws JsonMappingException
     */
    public function getGames(): GetGamesResponseContainer
    {
        $url = "{$this->authInfo->baseUrl}/{$this->controller}/GetGameList";

        $rawHash = "{$this->authInfo->merchantId}|{$this->authInfo->privateKey}";
        $hash = $this->getSha256($rawHash);

        $data['MerchantId'] = $this->authInfo->merchantId;
        $data['Hash'] = $hash;

        $response = $this->postRequest($url, $data);

        $result = new GetGamesResponseContainer();
        $result = $this->mapFromJsonToClass($response->body, $result);

        return $this->cast($result);
    }

    private function cast($obj): GetGamesResponseContainer
    {
        return $obj;
    }
}