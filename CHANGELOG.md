### 2017-12-09
- ubah method framework jadi menggunakan composer
- 

### 2017-11-24
- perbaikan konstanta `PUBLIC_PATH`
- perbaikan beberapa functions

### 2017-09-16
- change routing method

___

### 2017-09-15
- check session param before reverse
- add `insertOrUpdateData` query function
- change `clnData` function to `_input` and move to function
- add `_file` function

___

### 2017-09-05
- add variable `auth` and `route` in `controller` function

___

### 2017-08-27
- add controller function
- change routing method to controller first

___

### 2017-08-26
- add some new params in `queries`
- add json type in `debug` function

___

### 2017-08-15
- add `setFlashMessage` function
- add `where_between` query parameter function
- add `offset` query parameter function
- refine **where** & **order** query
- add debug sql function
- separate **where** query function
- remove `require_once` config script
- change unset session params to empty array
- reset key params

___

### 2017-07-28
- comment file caching
- move `$default_page` from `index.php` to `init.php`

___

### 2017-07-23
- add file caching
- add memcached caching

___

### 2017-07-22
- add upload file function
- add image optimation function
- add send mail function

___

### 2017-07-20
- fix routing
- finishing default queries
- change routing method
- rollback route method
- add dynamic route handler

___

### 2017-07-19
- restructur folder dan files
- add `PHPMailer` to folder `lib`
- add `getParameters()` function
- move `routes.php` to folder `app`
- ignore `configuration.php` in git

___

### 2017-07-18
- **PROJECT INITIATION** (remake from older projects)
- restructur folders and files
- add `error` handler
- add `routing` function
- add `logging` function