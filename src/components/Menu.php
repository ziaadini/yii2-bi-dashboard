<?php

namespace sadi01\bidashboard\components;


use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Class Menu
 * Theme menu widget.
 */
class Menu extends \yii\widgets\Menu
{
    /**
     * @inheritdoc
     */
    public $linkTemplate = '<a href="{url}" class="sidebar-link">{icon}<span class="hide-menu">{label}</span></a>';
    public $labelTemplate = '<p>{label}</p>';
    public $submenuTemplate = "<ul class='collapse {level}' >{items}</ul>";
    public $activateParents = true;
    public $groups = [];
    protected $output;

    private $noDefaultAction;
    private $noDefaultRoute;

    public function run()
    {
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
        $posDefaultAction = strpos($this->route, Yii::$app->controller->defaultAction);
        if ($posDefaultAction) {
            $this->noDefaultAction = rtrim(substr($this->route, 0, $posDefaultAction), '/');
        } else {
            $this->noDefaultAction = false;
        }
        $posDefaultRoute = strpos($this->route, Yii::$app->controller->module->defaultRoute);
        if ($posDefaultRoute) {
            $this->noDefaultRoute = rtrim(substr($this->route, 0, $posDefaultRoute), '/');
        } else {
            $this->noDefaultRoute = false;
        }
        $items = $this->normalizeItems($this->items, $hasActiveChild);
        if (!empty($items)) {
            $options = $this->options;
            $tag = ArrayHelper::remove($options, 'tag', 'ul');
            foreach ($items as $i => $item) {
                if (isset($item['group']))
                    $this->groups[$item['group']][$i] = $item;
            }

            foreach ($this->groups as $key => $group) {
                $this->output .= $this->renderItems($group);
                $this->output .= Html::tag('div', '', ['class' => 'devider']);
            }
            echo Html::tag($tag, $this->output, $options);
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderItem($item)
    {
        if (isset($item['level']) && $item['level']) {
            $labelTemplate = '<a href="{url}"><p>{label}</p></a>';
            $linkTemplate = isset($item['items']) ? '<a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" >{icon} <span class="hide-menu">{label}</span></a>' :
                '<a class="sidebar-link" href="{url}">{icon}<p>{label}</p></a>';
        } else {
            $labelTemplate = $this->labelTemplate;
            $linkTemplate = $this->linkTemplate;
        }

        if (isset($item['url']) || isset($item['level'])) {
            $template = ArrayHelper::getValue($item, 'template', $linkTemplate);
            $replace = [
                '{url}' => isset($item['url']) ? Url::toRoute($item['url']) : '',
                '{label}' => $item['label'],
                '{icon}' => !empty($item['icon']) ? '<i class="' . $item['icon'] . ' "></i>' : null
            ];
            return strtr($template, $replace);
        } else {
            $template = ArrayHelper::getValue($item, 'template', $labelTemplate);
            $replace = !empty($item['icon']) ? [
                '{label}' => $item['label'],
                '{icon}' => '<i class="fas fa-">' . $item['icon'] . '</i> '
            ] : [
                '{label}' => '<span>' . $item['label'] . '</span>',
            ];
            return strtr($template, $replace);
        }
    }

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];

            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class)) {
                if (empty($options['class'])) {
                    $options['class'] = implode(' ', $class);
                } else {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }
            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $menu .= strtr($this->submenuTemplate, [
                    '{level}' => isset($item['level']) ? $item['level'] : "first-level",
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }

    /**
     * @inheritdoc
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $items[$i]['label'] = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $items[$i]['icon'] = isset($item['icon']) ? $item['icon'] : '';
            $hasActiveChild = false;
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
                if (empty($items[$i]['items']) && $this->hideEmptyItems) {
                    unset($items[$i]['items']);
                    if (!isset($item['url'])) {
                        unset($items[$i]);
                        continue;
                    }
                }
            }
        }
        return array_values($items);
    }
}
