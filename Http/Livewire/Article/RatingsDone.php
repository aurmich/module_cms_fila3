<?php

declare(strict_types=1);

namespace Modules\Blog\Http\Livewire\Article;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Blog\Datas\RatingInfoData;
use Modules\Rating\Models\RatingMorph;
use Modules\Xot\Actions\GetViewAction;
use Webmozart\Assert\Assert;

class RatingsDone extends Component // implements HasForms, HasActions
{// use InteractsWithActions;
    // use InteractsWithForms;

    public array $user_ratings;
    public array $article_data;
    public array $user;

    public function mount(array $article_data): void
    {
        $this->article_data = $article_data;

        Assert::notNull($user = Auth::user());
        $this->user = $user->toArray();

        $this->user_ratings = $this->getUserRatings();

        // $user_ratings = RatingMorph::where('user_id', $user->id)
        //         ->where('model_id', $this->article_data['id'])
        //         ->get()->toArray();

        // $ratings_options = collect($this->article_data['ratings']);

        // foreach ($user_ratings as $key => $rating) {
        //     Assert::isArray($rating);
        //     $tmp = $ratings_options->where('id', $rating['rating_id'])->first();
        //     $this->user_ratings[] = RatingInfoData::from([
        //         'ratingId' => $rating['rating_id'],
        //         'title' => $tmp['title'],
        //         'credit' => $rating['value'],
        //         'image' => $tmp['image'],
        //     ])->toArray();
        // }

        // dddx($this->user_ratings);
    }

    public function getUserRatings(): array
    {
        $result = [];

        $user_ratings = RatingMorph::where('user_id', $this->user['id'])
                ->where('model_id', $this->article_data['id'])
                ->get()->toArray();

        Assert::isArray($this->article_data['ratings']);
        $ratings_options = collect($this->article_data['ratings']);

        foreach ($user_ratings as $key => $rating) {
            Assert::isArray($rating);
            $tmp = $ratings_options->where('id', $rating['rating_id'])->first();
            $result[] = RatingInfoData::from([
                'ratingId' => $rating['rating_id'],
                'title' => $tmp['title'],
                'credit' => $rating['value'],
                'image' => $tmp['image'],
            ])->toArray();
        }

        return $result;
    }

    #[On('update-user-ratings')]
    public function updateUserRatings(): void
    {
        $this->user_ratings = $this->getUserRatings();

        $this->render();
    }

    public function render(): View
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute();

        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
