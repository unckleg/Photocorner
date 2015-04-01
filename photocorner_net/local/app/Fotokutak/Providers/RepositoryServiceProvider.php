<?php
/**
 *@author Djordje Stojiljkovic & Nikola Stojic <djordjewebdizajn@gmail.com>
 */
namespace Fotokutak\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Fotokutak\Repository\ImagesRepositoryInterfaceInterface',
            'Fotokutak\Repository\Eloquent\ImagesRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\UsersRepositoryInterface',
            'Fotokutak\Repository\Eloquent\UsersRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\BlogsRepositoryInterface',
            'Fotokutak\Repository\Eloquent\BlogsRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\CategoryRepositoryInterface',
            'Fotokutak\Repository\Eloquent\CategoryRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\FlagsRepositoryInterface',
            'Fotokutak\Repository\Eloquent\FlagsRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\CommentsRepositoryInterface',
            'Fotokutak\Repository\Eloquent\CommentsRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\ReplyRepositoryInterface',
            'Fotokutak\Repository\Eloquent\ReplyRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\VotesRepositoryInterface',
            'Fotokutak\Repository\Eloquent\VotesRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\FollowRepositoryInterface',
            'Fotokutak\Repository\Eloquent\FollowRepository'
        );

        $this->app->bind(
            'Fotokutak\Repository\FavoriteRepositoryInterface',
            'Fotokutak\Repository\Eloquent\FavoriteRepository'
        );
    }
}