<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

class GetSicureArrayByModelAction
{
    use QueueableAction;

    /**
     * @return array<Index>
     */
    public function execute(Model $model): array
    {
        try{
            return $model->attributesToArray(); //"" is not a valid backing value for enum Modules\SaluteOra\Enums\OccurrenceFrequencyEnum
        }catch(\ValueError $e){
            $data=[];
            foreach($model->getAttributes() as $key=>$value){
                try{
                    $data[$key]=$this->$key;
                    /** @phpstan-ignore-next-line */
                }catch(\ValueError $e){
                    
                }
            }
           
            return $data;
        }
    }
}
