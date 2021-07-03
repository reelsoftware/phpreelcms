<?php
namespace App\Helpers\Content; 

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface IContentBuilder
{
    public function validate(): IContentBuilder;
    public function store(): IContentBuilder;
    public function update($id): IContentBuilder;
}