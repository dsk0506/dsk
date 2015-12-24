如何查看当前项目的远程地址呢?
git remote -v

从服务器获取项目（代码）到本地
--git clone git@192.168.2.153:~/wealink_dev wealink_dev.git  (目标文件夹)
git clone git@192.168.2.172:/Users/dsk/code/gittest test  (目标文件夹)

git  账号没有权限
查看所有分支
git branch -a
创建本地分支
git branch hehe
切换分支
git checkout hehe
修改一个文件
vi  test.php
查看修改状态
git status
添加跟进
git add test.php
继续查看状态
git status
取消跟进文件
git reset HEAD test.php
提交分支到远程(如果远程没有则创建)
git push origin hehe
删除分支（你必须不再当前分支上才可以删除这个分支）
git branch -d hehe


获取远程分支
git pull  origin hehe:hehe
提交代码
git commit -m 'test.php'
查看提交log（1条）
git log -1
从提交中删除（有点危险）
git revert 3a591daaeab4c4cfbf96db7f6e9e9cf497f26b63
提交后必须从服务器拉去最新代码（防止覆盖）
git pull origin hehe
如果有冲突就需要合并代码（合并比较只能，不演示）
把合并后的代码推倒服务器上
git push origin hehe

提高（合并代码）
切到主分支
［例如］
git checkout develop
拉取crm分支代码   crm201501
git pull origin crm201501

把合并后的代码推到服务器上 即可合并代码

日志查询
git log  --after="2015-02-01" --name-status --author="dingshoukun" |grep -E 'M\s+|A\s+' |awk "{print \$2}"|sort|uniq

git reset  （比较危险指令）
回到以前的版本
例如：
git reset --soft

分支之间的比较