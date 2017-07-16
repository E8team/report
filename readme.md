<p align="center">
  <img style="max-width:50%" src="https://avatars2.githubusercontent.com/u/15854856?v=3&s=150">
  <img style="max-width:50%" src="https://avatars1.githubusercontent.com/u/28562345?v=3&s=150">
  <br><strong>3t</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>E8net</strong>
</p>
<p align="center">
<a href="https://travis-ci.org/3tnet/t-cms"><img src="https://travis-ci.org/3tnet/t-cms.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/E8team/report"><img src="https://poser.pugx.org/E8team/report/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/E8team/report"><img src="https://poser.pugx.org/E8team/report/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/E8team/report"><img src="https://poser.pugx.org/E8team/report/license.svg" alt="License"></a>
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
