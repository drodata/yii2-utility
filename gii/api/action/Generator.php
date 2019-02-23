<?php
namespace drodata\gii\api\action;

use Yii;
use yii\gii\CodeFile;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\Markdown;

/**
 * This generator will generate a controller and one or a few action view files.
 *
 * @property array $actionIDs An array of action IDs entered by the user. This property is read-only.
 * @property string $controllerFile The controller class file path. This property is read-only.
 * @property string $controllerID The controller ID. This property is read-only.
 * @property string $controllerNamespace The namespace of the controller class. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    /**
     * @var string the action class name
     */
    public $actionClass = 'api\actions\\';
    /**
     * @var string 对应的 ActiveRecord 模型类
     */
    public $modelClass = 'backend\models\\';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'RESTful API Action Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator helps you to quickly generate a new controller class with
            one or several controller actions and their corresponding views.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['actionClass', 'modelClass'], 'filter', 'filter' => 'trim'],
            [['actionClass', 'modelClass'], 'required'],
            [['actionClass', 'modelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'actionClass' => 'Action Class',
            'modelClass' => 'Model Class',
        ];
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return [
            'action.php',
        ];
    }

    /**
     * @inheritdoc
     */
    public function stickyAttributes()
    {
        return ['actionClass', 'modelClass'];
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return [
            'actionClass' => 'Action Class name',
            'modelClass' => 'Related ActiveRecord class',
        ];
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        $message = <<<MSG
Created.
MSG;
        return Markdown::process($message);
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];

        $files[] = new CodeFile(
            $this->getActionFile(),
            $this->render('action.php')
        );

        return $files;
    }

    /**
     * @return string the action class file path
     */
    public function getActionFile()
    {
        return Yii::getAlias('@' . str_replace('\\', '/', $this->actionClass)) . '.php';
    }
    /**
     * @return string the controller ID
    public function getControllerID()
    {
        $name = StringHelper::basename($this->controllerClass);
        return Inflector::camel2id(substr($name, 0, strlen($name) - 10));
    }
     */

    /**
     * @return string the namespace of the controller class
     */
    public function getActionNamespace()
    {
        $name = StringHelper::basename($this->actionClass);
        return ltrim(substr($this->actionClass, 0, - (strlen($name) + 1)), '\\');
    }
}
