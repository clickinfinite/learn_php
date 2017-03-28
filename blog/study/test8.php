<?php 

/*
	setcookie的详细参数
	bool setcookie ( string $name [, string $value = "" [, int $expire = 0 [, string $path = "" [, string $domain = "" [, bool $secure = false [, bool $httponly = false ]]]]]] )
	setcookie() 定义了 Cookie，会和剩下的 HTTP 头一起发送给客户端。 和其他 HTTP 头一样，必须在脚本产生任意输出之前发送 Cookie（由于协议的限制）。 请在产生任何输出之前（包括 <html> 和 <head> 或者空格）调用本函数。

	一旦设置 Cookie 后，下次打开页面时可以使用 $_COOKIE 读取。 Cookie 值同样也存在于 $_REQUEST。
 */


/*
name
Cookie 名称。

value
Cookie 值。 这个值储存于用户的电脑里，请勿储存敏感信息。 比如 name 是 'cookiename'， 可通过 $_COOKIE['cookiename'] 获取它的值。

expire
Cookie 的过期时间。 这是个 Unix 时间戳，即 Unix 纪元以来（格林威治时间 1970 年 1 月 1 日 00:00:00）的秒数。 也就是说，基本可以用 time() 函数的结果加上希望过期的秒数。 或者也可以用 mktime()。 time()+60*60*24*30 就是设置 Cookie 30 天后过期。 如果设置成零，或者忽略参数， Cookie 会在会话结束时过期（也就是关掉浏览器时）。

Note:
你可能注意到了，expire 使用 Unix 时间戳而非 Wdy, DD-Mon-YYYY HH:MM:SS GMT 这样的日期格式，是因为 PHP 内部作了转换。

path
Cookie 有效的服务器路径。 设置成 '/' 时，Cookie 对整个域名 domain 有效。 如果设置成 '/foo/'， Cookie 仅仅对 domain 中 /foo/ 目录及其子目录有效（比如 /foo/bar/）。 默认值是设置 Cookie 时的当前目录。

domain
Cookie 的有效域名/子域名。 设置成子域名（例如 'www.example.com'），会使 Cookie 对这个子域名和它的三级域名有效（例如 w2.www.example.com）。 要让 Cookie 对整个域名有效（包括它的全部子域名），只要设置成域名就可以了（这个例子里是 'example.com'）。

旧版浏览器仍然在使用废弃的 » RFC 2109， 需要一个前置的点 . 来匹配所有子域名。

secure
设置这个 Cookie 是否仅仅通过安全的 HTTPS 连接传给客户端。 设置成 TRUE 时，只有安全连接存在时才会设置 Cookie。 如果是在服务器端处理这个需求，程序员需要仅仅在安全连接上发送此类 Cookie （通过 $_SERVER["HTTPS"] 判断）。

httponly
设置成 TRUE，Cookie 仅可通过 HTTP 协议访问。 这意思就是 Cookie 无法通过类似 JavaScript 这样的脚本语言访问。 要有效减少 XSS 攻击时的身份窃取行为，可建议用此设置（虽然不是所有浏览器都支持），不过这个说法经常有争议。 PHP 5.2.0 中添加。 TRUE 或 FALSE
 */


setcookie('test', '!!!', time()+60);  //过期时间是60s以后
setcookie('test1', 'test1'); //不设置的话，那么直接在关闭浏览器就删除了这个cookie
setcookie('test2', 'test2', time()+60, '/'); 
//整个网站都能访问这个cookie,不加‘/’--那么只有下级目录才能读到这个cookie
//上级目录不能访问到这个cookie


// book.test1.com mail.test1.com这些子域名都能
// test1.com访问到cookie
setcookie('test3', 'test3', time()+60, '/', 'test1.com');
 ?>