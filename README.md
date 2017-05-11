Estate offers' price tracker
===================================================



## 1. Clone the project
```$ git clone https://t6nnp6nn@bitbucket.org/andmemasin/estate-tracker.git```

## 2. Composer install
```$ composer install```

## 3. Run Yii2-user migrations
```$ php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations```

## 4. Run app migrations
```$ php yii migrate/up```

## 5. initialize git for versioning
```
$ git init
$ git git remote add origin https://t6nnp6nn@bitbucket.org/andmemasin/estate-tracker.git


# Verify new remote
$ git remote -v

# fetch all versions
$ git fetch --all

# install version you need
$ git checkout 0.2.1

# re-run composer install & migrations

```
