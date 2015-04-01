<?php
/**
 * @author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Repository;

use Auth;
use Carbon;
use Feed;
use Hash;
use URL;
use User;

interface UsersRepositoryInterface {

    /**
     * @param $id
     * @return bool
     */
    public function getById($id);

    /**
     * @param $username
     * @return bool
     */
    public function getByUsername($username);

    /**
     * @return mixed
     */
    public function getAllUsers();

    /**
     * @return mixed
     */
    public function getTrendingUsers();

    /**
     * @param User $user
     * @internal param $username
     * @return mixed
     */
    public function getUsersFavorites(User $user);

    /**
     * @param $username
     * @return mixed
     */
    public function getUsersFollowers($username);

    /**
     * @param $username
     * @return mixed
     */
    public function getUsersFollowing($username);

    /**
     * @param User $user
     * @return mixed
     */
    public function getUsersImages(User $user);

    /**
     * @param array $input
     * @return bool
     */
    public function createNew(array $input);

    /**
     * @param $id
     * @return mixed
     */
    public function notifications($id);

    /**
     * @param $username
     * @param $activationCode
     * @return bool
     */
    public function activate($username, $activationCode);

    /**
     * @param array $input
     * @param null  $session
     * @return mixed
     */
    public function createFacebookUser(array $input, $session = null);

    /**
     * @param array $input
     * @param null  $session
     * @return mixed
     */
    public function createGoogleUser(array $input, $session = null);

    /**
     * @param $input
     * @return mixed
     */
    public function updateProfile($input);

    /**
     * @param $input
     * @return bool
     */
    public function updateMail($input);

    /**
     * @param $input
     * @return bool
     */
    public function updatePassword($input);

    /**
     * @return mixed
     */
    public function getFeedForUser();

    /**
     * @param $username
     * @return mixed
     */
    public function getUsersRss($username);
}