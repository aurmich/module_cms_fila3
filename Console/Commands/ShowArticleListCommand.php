<?php

<<<<<<< HEAD
<<<<<<< HEAD
declare(strict_types=1);

namespace Modules\Blog\Console\Commands;

use Illuminate\Console\Command;
use Modules\Blog\Models\Article;

=======
=======
declare(strict_types=1);

>>>>>>> 934879b (Lint)
namespace Modules\Blog\Console\Commands;

use Illuminate\Console\Command;
use Modules\Blog\Models\Article;

>>>>>>> e600cc0 (.)
class ShowArticleListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:article-list';

    /**
     * The console command description.
     *
     * @var string
     */
<<<<<<< HEAD
    protected $description = 'Visualizza lista articoli';
=======
    protected $description = 'Command description';
>>>>>>> e600cc0 (.)

    /**
     * Execute the console command.
     */
    public function handle()
    {
<<<<<<< HEAD
<<<<<<< HEAD
        $map = function (Article $row) {
            $result = $row->toArray();

            // $result['price'] = Money::toString($result['price']);
=======
        $map = function (Article $row){
            $result = $row->toArray();

            //$result['price'] = Money::toString($result['price']);
>>>>>>> e600cc0 (.)
=======
        $map = function (Article $row) {
            $result = $row->toArray();

            // $result['price'] = Money::toString($result['price']);
>>>>>>> 934879b (Lint)

            return $result;
        };

        $rows = Article::all(['id', 'title'])->map($map);

        if (count($rows) > 0) {
<<<<<<< HEAD
<<<<<<< HEAD
=======

>>>>>>> e600cc0 (.)
=======
>>>>>>> 934879b (Lint)
            $headers = array_keys($rows[0]);

            $this->newLine();
            $this->table($headers, $rows);
            $this->newLine();
<<<<<<< HEAD
<<<<<<< HEAD
        } else {
=======
        }
        else {
>>>>>>> e600cc0 (.)
=======
        } else {
>>>>>>> 934879b (Lint)
            $this->newLine();
            $this->warn('⚡ No products in the stock');
            $this->newLine();
        }
    }
}
