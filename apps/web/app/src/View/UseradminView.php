<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link https://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class UseradminView extends AppView
{

    public function initialize() : void
    {
        parent::initialize();

        $form_templates = [
               'inputContainer' => '{{content}}',
                'inputContainerError' => '{{content}}{{error}}',
                'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>',
                'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                'radioWrapper' => '<div class="radio icheck-midnightblue d-inline mr-2">{{label}}</div>',
                'error' => '<p class="error-message">{{content}}</p>',

                'checkboxWrapper' => '<div class="checkbox icheck-midnightblue">{{label}}</div>',
                'checkboxFormGroup' => '{{label}}',
                'checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>',
         ];

         $this->set(compact('form_templates'));

    }

}
