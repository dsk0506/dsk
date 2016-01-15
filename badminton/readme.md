# 安装指南

###nginx 配置

```
server {

    listen 80;
    server_name *.gittest.com;
    root path/badminton/public;
    index index.html index.php;
    location / {
      try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include        fastcgi.conf;
    }
}
```

###php配置

略

###数据库

在.env修改正确的数据库配置 并新建数据库badminton

###数据迁移

项目目录中运行
```
php artisan migrate
```
准备预数据
用户数据
```
php artisan db:seed --class=user
```
活动数据
```
php artisan db:seed --class=active
```
报名数据
```
php artisan db:seed --class=active_user
```

###任务

- 录入裁判

- 并在录入分数的时候校验权限(项目管理者和裁判可以录入分数,录入分数缺少类型)

- 优化场地分配(一只队伍不能连续出现两次)[我在处理]

- 优化排序(先按场  再按局  再按分  再按先后时间[或默认顺序])[我在处理]

- 单打 双打循环的配置

