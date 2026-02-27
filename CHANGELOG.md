# Change Log

### 1.0.2 2026-02-27

- `Html::actionLink()` 配置增加 `text` 选项，原来的 `title` 让链接的内容和 hover text 一样，在某些情况下不易区分。新配置例子： `Html::actionLink('view', ['title' => 'view detail', 'text' => 3333])`;

### 1.0.16 2016-08-30

- validator: 新增身份证号码 CitizenIdValidator;

### 1.0.15 2016-08-27

Gii template: 将 `yii\bootstrap\Html` 替换为 `drodata\helpers\Html`;

### 1.0.12 2016-08-27

### 1.0.11 2016-08-27

- helpers: customize yii\bootstrap\Html::icon(), use fa icons;

### 1.0.10 2016-08-27

- Gii template: added `scenarios()` in Model template

### 1.0.3 2015-11-29

- controller template: Access Filter 默认只有登录用户能访问；

##1.0.2 November 28, 2015

- Enh: `title` property of `Panel` widget could be `false`, which will hide panel header.
##0.1.3 couldn't be cloned.

