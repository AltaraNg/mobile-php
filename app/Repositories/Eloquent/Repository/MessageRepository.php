<?php

namespace App\Repositories\Eloquent\Repository;
use App\Models\Message;
class MessageRepository extends BaseRepository
{
    public function __construct(Message $model)
    {
        parent::__construct($model);
    }


}
