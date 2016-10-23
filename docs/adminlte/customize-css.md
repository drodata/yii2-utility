# 自定义样式

## Bootstrap

- Tooltip 内容不管内容长短，一律单行显示；
- 增加 `.popover-fullwidth-wrapper` 类，支持 Popover 内容不限宽度。用 .popover-fullwidth-wrapper 类包裹 popover 即可

## AdminLTE

- Font awesome 图标两侧添加 2px 空隙，涉及到的位置有：
    - Active form label 中。有时我们需要使用 Popover 将 label 做进一步的解释，此时可以在 label 文本内容后面加个 question icon, 为了避免图标紧挨着 label 字体，我们加一个空隙； 
    - Gridview action column 内的多个操作图标间不能挨得太近
    - AdminLTE 自定义 Tabs 的 title 内；
