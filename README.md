# graphql-blog

### I. Instalation
```bash
$ composer install
$
$ php bin/console doctrine:schema:update --force
$
$ php bin/console doctrine:fixtures:load
$
$ php bin/console server:run
```

Go to http://127.0.0.1:8000/graphiql

## II. CRUD

#### Create an new article: 

```php
mutation NewArticle($article: ArticleInput!) {
  NewArticle(input: $article) {
    content
  }
}
```

Query variables:

```json
{
  "article": {
    "title": "new articless",
    "content": "super articless",
    "category_id": 8,
    "author_id": 1
  }
}
```

#### Read an article: 

```
{
  Article(id: 26) {
    title
    content
    author {
      name
      id
    }
    comments {
      id
      content
    }
    category {
      id
      name
    }
  }
}
```

#### Update an article: 

```php
mutation UpdateArticle($article: ArticleUpdateInput!) {
  UpdateArticle(input: $article) {
    content
  }
}
```

Query variables:

```json
{
  "article": {
    "id": 26,
    "title": "last articles update",
    "content": "Should Update the last article",
    "category_id": 8,
    "author_id": 1
  }
}
```

#### Delete an article: 

```php
mutation DeleteArticle($article: ArticleDeleteInput!) {
  DeleteArticle(input: $article) {
    content
  }
}
```

Query variables:

```json
{
  "article": {
    "id": 26
  }
}
```


#### Get all articles: 

```
{
  Articles {
    title
    content
    author {
      name
      id
    }
    comments {
      id
      content
    }
    category {
      id
      name
    }
  }
}
```