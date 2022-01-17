<?php

namespace App\Admin\Controllers;

use App\Models\Image;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;


class ImageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Image';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Image);
        $grid->expandFilter();
        $grid->column('id', __('Id'));
        $grid->column('image_url', __('Image'))->display(function () {
            $image_url = config('filesystems.disks.admin.url') . '/' . $this->image_url;
            return '<a href="' . $image_url . '" target="_blank"><img width="150" src="' . $image_url . '"></a>';
        });
        $grid->column('description', __('Description'));
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    public function detail($id)
    {
        $row = Image::findOrFail($id);
        $show = new Show($row);
        $show->field('image_url', __('Image'))->as(function($field) {
            $image_url = config('filesystems.disks.admin.url') . '/' . $field;
            return '<a href="' . $image_url . '" target="_blank"><img style = "max-width:800px" src="' . $image_url . '"></a>';
        })->unescape();
        $show->field('description', 'Description');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Image);
        $form->image('image_url', 'Upload Image');
        $form->textarea('description', 'Description');
        return $form;
    }
}