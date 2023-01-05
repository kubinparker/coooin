<?php
declare(strict_types=1);

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

use App\Model\Entity\Useradmin;
use Cake\View\View;

/**
 * Application View
 *
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class AppView extends View
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

//        $this->loadHelper('Common'); // 自動読込なので通常は追記する必要ない
        $this->loadHelper('Html', ['className' => 'MyHtml']);
        $this->loadHelper('Form', ['className' => 'MyForm',
                                   'errorClass' => 'error',
                                   'templates' => [
                                       'inputContainer' => '{{content}}',
                                        'inputContainerError' => '{{content}}<div class="error-message">{{error}}</div>',
                                        'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>',
                                        'radio' => '<input type="radio" name="{{name}}" value="{{value}}"{{attrs}}>',
                                        'radioWrapper' => '<span style="margin-right:10px;color:#000;">{{label}}</span>'
                                   ]]);

        $user_roles = Useradmin::$role_key_values;

        $Session = $this->getRequest()->getSession();

        $this->set(compact('Session', 'user_roles'));
    }
}
