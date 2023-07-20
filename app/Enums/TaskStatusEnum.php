<?php

namespace App\Enums;

enum TaskStatusEnum: string
{
    case Open = 'Open';
    case Inprogress = 'In progress';
    case Done = 'Done';
    case Closed = 'Closed';
    case Cancelled = 'Cancelled';
}
