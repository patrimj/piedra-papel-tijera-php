# PIEDRA-PAPEL-TIJERA EN PHP

# API de Autenticación de Usuarios

### Iniciar sesión

- URL: `http://127.0.0.1:8000/api/login`
- Método: `POST`
- Datos requeridos:
  - `email`: Email del usuario (string, requerido)
  - `password`: Contraseña del usuario (string, requerido)

## Ejemplo de solicitud de inicio de sesión

```json
{
    "email": "barton.percy@example.net",
    "password": "contraseña"
}
```

## Ejemplo de respuesta de inicio de sesión

```json
{
  "usuario": {
    "token": "2|UqBfsL2y0yAuXY1zj5U5QS0YxUHdWM2CxBVCI0jjda249048"
  },
  "message": "Inicio de sesión"
}
```
### Cerrar sesión

- URL: `http://127.0.0.1:8000/api/logout`
- Método: `POST`
- Encabezados requeridos:
  - `Authorization`: `Bearer <token_de_autenticacion>`
 
  - Haz clic en la pestaña "Headers" y añade un nuevo encabezado con "Authorization" como clave y "Bearer tu_token" como valor. Reemplaza "tu_token" con el token de autenticación que obtuviste al iniciar sesión.

## Ejemplo de solicitud de cierre de sesión

```http
POST /api/logout
Authorization: Bearer token_de_autenticacion
```

## Ejemplo de respuesta de cierre de sesión

```json
{
    "message": "Sesión cerrada con éxito"
}
```

### Registrarse

- URL: `http://127.0.0.1:8000/api/registrarse`
- Método: `POST`
- Datos requeridos:
  - `nombre`: Nombre del usuario (string, requerido)
  - `email`: Email del usuario (string, requerido, debe ser un email válido y único)
  - `password`: Contraseña del usuario (string, requerido, mínimo 8 caracteres)
  - `rol`: Rol del usuario (integer, opcional)

### Ejemplo de solicitud

```json
{
    "nombre": "patricia",
    "email": "patricia@ejemplo.com",
    "password": "1234holahola",
    "rol": 1
}
```
### Ejemplo de la respuesta
```json
{
  "usuario": {
    "token": "1|rHZrYEbJyTZZHK409oMFPYUoo9L5kbk43TKBYJW964fca38f"
  },
  "message": "usuario creado"
}
```

# API de Usuarios

### Obtener todos los usuarios

- URL: `http://127.0.0.1:8000/api/usuario/todos`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Obtener un usuario por ID

- URL: `http://127.0.0.1:8000/api/usuario/{id}`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Crear un nuevo usuario

- URL: `http://127.0.0.1:8000/api/usuario/nuevo`
- Método: `POST`
- Encabezado requerido: `Authorization: Bearer <tu_token>`
- Datos requeridos:
  - `email`: Email del usuario (string, requerido)
  - `password`: Contraseña del usuario (string, requerido)

### Modificar un usuario

- URL: `http://127.0.0.1:8000/api/usuario/modificar/{id}`
- Método: `PUT`
- Encabezado requerido: `Authorization: Bearer <tu_token>`
- Datos requeridos:
  - `email`: Email del usuario (string, requerido)
  - `password`: Contraseña del usuario (string, requerido)

### Eliminar un usuario

- URL: `http://127.0.0.1:8000/api/usuario/eliminar/{id}`
- Método: `DELETE`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

# API de Partidas

### Eliminar una partida

- URL: `http://127.0.0.1:8000/api/partida/eliminar/{id}`
- Método: `DELETE`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Crear una partida

- URL: `http://127.0.0.1:8000/api/partida/crear`
- Método: `POST`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Obtener todas las partidas

- URL: `http://127.0.0.1:8000/api/partida/todas`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Obtener una partida por ID

- URL: `http://127.0.0.1:8000/api/partida/{id}`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Obtener el resultado de una partida

- URL: `http://127.0.0.1:8000/api/partida/resultado/{id}`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Finalizar una partida

- URL: `http://127.0.0.1:8000/api/partida/finalizar/{id}`
- Método: `PUT`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Jugar una partida

- URL: `http://127.0.0.1:8000/api/partida/jugar`
- Método: `POST`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Obtener el ranking de las partidas

- URL: `http://127.0.0.1:8000/api/partida/ranking`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

# API de Información de Usuario

### Obtener la información de un usuario

- URL: `http://127.0.0.1:8000/api/usuario/informacion{id}`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

# API de Tiradas

### Obtener todas las tiradas

- URL: `http://127.0.0.1:8000/api/tirada/todas`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Obtener una tirada por ID

- URL: `http://127.0.0.1:8000/api/tirada/{id}`
- Método: `GET`
- Encabezado requerido: `Authorization: Bearer <tu_token>`

### Realizar una tirada

- URL: `http://127.0.0.1:8000/api/tirada/tirada`
- Método: `POST`
- Encabezado requerido: `Authorization: Bearer <tu_token>`


