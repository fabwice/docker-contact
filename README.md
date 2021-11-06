# Docker contact http server with `Google` SMTP
 
The contact form has to send an e-mail and display all the possible errors.

- [x] A contact form with php
- [x] Backend : deploy with docker
- [x] Backend : Use of an google SMTP server to send emails

## Utilisation dans un `docker-compose.yml`

```
version: '3'

services:
  contact-http:
    restart: unless-stopped
    image: fabwice/contact-http:latest
    container_name: contact-http
    ports:
      - "127.0.0.1:8081:80"
    environment:
      GMAIL_USER_NAME: "contact@_gmail.com"
      GMAIL_USER_PASSWORD: "secret***"
      FROM_USER_MAIL: "contact@_fabwice_com"
      FROM_USER_NAME: "Contact Fabwice"
```
