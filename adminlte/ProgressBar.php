<?php
namespace drodata\adminlte;
use Yii;
use yii\base\InvalidConfigException;
use drodata\helpers\Html;

/**
 * Progress bar widget 
 *
 * ```php
 * echo ProgressBar::widget([
 *     'percent' => 90,
 *
 *     // the following is optional
 *     'color' => 'red',
 *     'striped' => true,
 *     'active' => true,
 *     'size' => 'sm',
 *     'vertical' => true,
 * ]);
 * ```
 *
 * @author Kui Chen <drodata@foxmail.com>
 * @since 1.0.16
 */
class ProgressBar extends \yii\bootstrap\Widget
{
    /**
     * @var string $color 'primary', 'green' etc.
     */
    public $color = 'primary';
    /**
     * @var string $size 'lg', 'xs', 'xxs' etc.
     */
    public $size = '';
    /**
     * @var bool $active 
     */
    public $active = false;
    /**
     * @var bool $striped 
     */
    public $striped = false;
    /**
     * @var bool $vertical 
     */
    public $vertical = false;

    /**
     * @var decimal $percent e.g. 0.8 
     */
    public $percent;

    public $visible = true;

    public function init()
    {
        parent::init();

        if (is_null($this->percent)) {
            throw new InvalidConfigException('The percent option is required.');
        }
    }

    public function run()
    {
        if (!$this->visible) {
            return '';
        } 

        return $this->renderProgressBar();
    }

    protected function renderProgressBar()
    {
        $outClasses = ['progress'];
        if ($this->size) {
            array_push($outClasses, 'progress-' . $this->size);
        }
        if ($this->active) {
            array_push($outClasses, 'active');
        }
        if ($this->vertical) {
            array_push($outClasses, 'vertical');
        }
        $outClass = implode(' ', $outClasses);

        $innerClasses = [
            'progress-bar',
            "progress-bar-{$this->color}",
        ];
        if ($this->striped) {
            array_push($innerClasses, 'progress-bar-striped');
        }
        $innerClass = implode(' ', $innerClasses);

        return <<<CONTENT
<div class="$outClass">
    <div class="$innerClass" role="progressbar" aria-valuenow="{$this->percent}" aria-valuemin="0" aria-valuemax="100" style="width: {$this->percent}%">
        <span class="sr-only">{$this->percent}% Complete</span>
    </div>
</div>
CONTENT;
    }
}
