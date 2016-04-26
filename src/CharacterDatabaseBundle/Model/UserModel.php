<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Model;

use CharacterDatabaseBundle\Entity\Character;
use CharacterDatabaseBundle\Entity\User;

class UserModel
{
    private $username;
    private $email;
    private $id;

    private $character;

    public function __construct(User $user)
    {
        $this->username = $user->getUsername();
        $this->email = $user->getEmail();
        $this->id = $user->getId();
        $this->character = $user->getCharacters()->map(function (Character $char) {
            return ['id' => $char->getId()];
        })->toArray();
    }

    public function toArray()
    {
        $array = [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'character' => $this->character,
        ];

        return $array;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCharacter()
    {
        return $this->character;
    }
}
