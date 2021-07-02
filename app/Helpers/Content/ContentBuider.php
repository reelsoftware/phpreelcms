<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface ContentBuilder
{
    public function validate(): ContentBuilder
    public function store(): ContentBuilder
    public function update(): ContentBuilder
}