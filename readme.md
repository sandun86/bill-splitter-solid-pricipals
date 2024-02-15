## Bill Splitter - Solid principals 

### Installation

- Clone the code
- Copy file `.env.sample` to `.env`
- Run `composer install` command
- Generate application encryption key `php artisan key:generate` 

### Host on a server that has LAMP
- Create a `bill-splitter.conf` file on `sites-available(/etc/apache2/sites-available)`
- Following has the sample `conf` file
```
<VirtualHost *:80>
        ServerName app-domain
        DocumentRoot /folder-path/public
         <Directory /folder-path/public>
                AllowOverride None
                Require all granted
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
- Enable `conf` command - `a2ensite bill-splitter.conf`
- Then `service apache2 restart`
- Adds `ServerName` into `/etc/hosts`

### Suggest enhancements

- Use a AWS instance and route the domain
- Use a `jenkins` job for a deployment. Mainly we need to consider the followings for the CI/CD job 
```
composer install 
checkout for the branch
seperate environment variables file
php artisan clear-compiled
php artisan optimize
php artisan view:clear
migrations 
```
- Use separate git branches for the deployments (dev, qa, Staging and production)
- Create a `tag` for a staging and production deployment
- Maintain separate files for environment variables
- Use a separate chanel for deployment notifications (Slack,google)  
- Implement logs (Implement ELK or Newrelic - APM)
- Better to use a `docker`

- We can add Cross-Site scripting protection for the spamming 

