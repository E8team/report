<p align="center">
  <img style="max-width:50%" src="https://avatars1.githubusercontent.com/u/28562345?v=3&s=150">
</p>


# 淮南师范学院2017新生报到

## 运行环境
- PHP >= 5.6.4
- Node >= 6.x
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension

## 安装

### 1. 克隆源代码

```shell
git clone https://github.com/E8team/report.git
cd report
```

### 2. 配置

```shell
cp .env.example .env
```
修改.env中的数据库相关配置

### 3. 安装扩展包依赖
```shell
composer install
```

### 4. 生成密钥
```shell
php artisan key:generate
```

### 5. 创建数据库并填充测试数据
```shell
php artisan migrate --seed
```
## 前端
1. 安装 node.js
直接去官网 https://nodejs.org/ 下载安装最新版本。
2. 安装前端依赖
```shell
npm install
```
### 4. 编译前端资源
```shell
npm run dev
```

## License

[MIT license](https://mit-license.org/).
