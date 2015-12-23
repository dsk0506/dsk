# 1.Markdown简明语法教程

“#” 后最好加个空格。除此之外，还有 5 级标题，依次有不同的字体大小，即

## 二级标题
### 三级标题
#### 四级标题
##### 五级标题
###### 六级标题

# 2.加粗，斜体

最常用的强调方式，那就是 **加粗** 了，你得这样

斜体则多用在于书名，比如：我从来没看过 *Jane Eyre*

# 3.层次

#### 第一章

1. 第一节
* 第二节(你不用敲 "2"，自动就有了）
    * 第一小节（推荐每层次缩进四个空格）
        * 小小节 1
        * 小小节 2
    * 第二小节

# 4. 链接，图片

我：我也没读过，但是， [***Jane Eyre***](http://book.douban.com/subject/1141406/) is not just ***Jane Eyre***
![](http://img3.douban.com/mpic/s1108264.jpg)

# 5. [其他][null-link]

你可能还没注意到本文每部分之间的分割线和 `其他` 的链接其实没有链接
我爱 `分割线`， 我爱 [**链接**][null-link]，哪怕它只有颜色~

[null-link]: chrome://not-a-link

# 6. 列表
```
- 文本1
- 文本2
- 文本3

1. 文本1
2. 文本2
3. 文本3
```

- 文本1
- 文本2
- 文本3

1. 文本1
2. 文本2
3. 文本3

# 7.应用代码
```
> 一盏灯， 一片昏黄； 一简书， 一杯淡茶。 守着那一份淡定， 品读属于自己的寂寞。 保持淡定， 才能欣赏到最美丽的风景！ 保持淡定， 人生从此不再寂寞。
```
效果
> 一盏灯， 一片昏黄； 一简书， 一杯淡茶。 守着那一份淡定， 品读属于自己的寂寞。 保持淡定， 才能欣赏到最美丽的风景！ 保持淡定， 人生从此不再寂寞。

# 8. 表格
代码
```
| Tables        | Are           | Cool  |
| ------------- |:-------------:| -----:|
| col 3 is      | right-aligned | $1600 |
| col 2 is      | centered      |   $12 |
| zebra stripes | are neat      |    $1 |
```
效果

| Tables        | Are           | Cool  |
| ------------- |:-------------:| -----:|
| col 3 is      | right-aligned | $1600 |
| col 2 is      | centered      |   $12 |
| zebra stripes | are neat      |    $1 |

# 9. 语法高亮
代码
```
\`\`\`php
echo "hello";

\`\`\`
```
效果
php
```php
echo "hello";

```
html
```html
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<script>
    $.post("test.php", function(data) {
        $(".result").html(data);
    });
</script>
</body>
</html>

```
