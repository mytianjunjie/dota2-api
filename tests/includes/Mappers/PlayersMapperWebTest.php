<?php

use Dota2Api\Mappers\PlayersMapperWeb;

class PlayersMapperWebTest extends PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $players_mapper_web = new PlayersMapperWeb();
        $players_info = $players_mapper_web->addId('76561198067833250')->addId('76561198058587506')->load();

        $this->assertEquals(count($players_info), 2);

        $this->assertEquals('76561198067833250', strval($players_info['76561198067833250']->get('steamid')));
        $this->assertEquals('76561198058587506', strval($players_info['76561198058587506']->get('steamid')));

        $this->assertStringStartsWith('http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/',
            $players_info['76561198067833250']->get('avatar'));
        $this->assertStringStartsWith('http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/',
            $players_info['76561198058587506']->get('avatar'));

        $this->assertStringStartsWith('http://steamcommunity.com/',
            $players_info['76561198067833250']->get('profileurl'));
        $this->assertStringStartsWith('http://steamcommunity.com/',
            $players_info['76561198058587506']->get('profileurl'));
    }

    public function testRemove_id()
    {
        $players_mapper_web = new PlayersMapperWeb();
        $players_mapper_web->addId(1)->addId(2)->addId(3);
        $this->assertEquals(array(1, 2, 3), array_values($players_mapper_web->getIds()));
        $players_mapper_web->removeId(2);
        $this->assertEquals(array(1, 3), array_values($players_mapper_web->getIds()));
    }
}