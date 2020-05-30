# Minimalist MVC Framework in Vanilla PHP

Source code for the post: TBD

## Try it with Docker

You can simply use the Docker image, already prepared:

### Build
```sh
docker image build -t php-apache-with-rewrite .
```

### Run
```sh
sudo docker run --rm -p 8080:80 -v $(pwd):/var/www/html php-apache-with-rewrite
```

### Try
```sh
curl http://localhost:8080/hello/user123
```

