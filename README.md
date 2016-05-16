#篮值1.0API

##CRUD

##API

* **清除API缓存**

```
php artisan api:cache
```

* **生成CRUD套件**

```
php artisan make:entity Activity
```

##生成API文档

* **需要安装apidoc**

```
npm install apidoc -g
```
* **在根目录下执行**

```
apidoc -i app/ -o apidoc/ -t doctemplate/
```

**接口文档小版本号修改**

历史接口文档复制_apidoc.js文件的History区域下

方便对比文档

