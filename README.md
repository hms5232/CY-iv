# CY-iv
## 需求
* PHP 7.3 或以上
* composer
* MariaDB 或 MySQL 資料庫

## 部署
1. Clone 或下載程式碼後切換至專案根目錄
2. `cp .env.example .env` 然後設定 `.env` 中的參數，主要有以下幾項需要設定：
    * `DB_` 開頭之資料庫相關設定
    * `FB_` 開頭之使用 FB 登入相關設定
3. `composer install`
4. `php artisan key:generate`
5. `php artisan migrate`
6. `php artisan serve` 來開啟測試用的 server 在 8000 連接埠

## 說明
* 專案使用 Laravel 8
* OAuth 以 FB 登入做示範
* 所有 API 對應與說明都在 [web.php](routes/web.php) 或見後章
* FB 登入需要跟 FB 申請一個應用程式來測試，如果有需要，相關環境設定已附在訊息中（但因為 FB 限制，需要另外新增帳號給予權限）
* 如果出現 419 錯誤可暫時更改 [VerifyCsrfToken.php](app/Http/Middleware/VerifyCsrfToken.php)
* 因為專案管理權限只有我一人，就不用 PR 的方式 merge 了

### API 路徑對應
| URI | 說明 |
|-----|------|
| `/csrf` | 取得 CSRF token 以利測試 |
| `/register` | 使用者註冊 |
| `/login` | 使用者登入 |
| `/logout` | 登出 |
| `/fb-login` | 使用者欲使用 FB 登入（給予跳轉 URL） |
| `/fb-login-callback` | FB 驗證使用者後回傳結果，後端替使用者建立資料及登入 |
| `/status` | 查看使用者當前登入狀態 |

## 參考資料
* https://laravel.com/docs/8.x
* https://rommelhong.medium.com/%E8%A7%A3%E6%B1%BA%E4%BD%BF%E7%94%A8postman%E6%B8%AC%E8%A9%A6laravel-6-post-request%E6%99%82%E9%81%87%E5%88%B0419-unknown-status%E7%9A%84%E9%8C%AF%E8%AA%A4-c81ecab8ce06
* https://dotblogs.com.tw/SmallFish/2019/11/17/140836
* https://hackmd.io/@8irD0FCGSQqckvMnLpAmzw/Hk8QeMNLz?type=view
* https://learnku.com/laravel/t/18864
* https://stackoverflow.com/questions/38911353/can-we-access-facebook-api-using-postman-client
* https://www.mxp.tw/5347/


----


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
