<!DOCTYPE html>
<html>
  <head>
    <title>Aventón</title>
    <meta charset= "UTF-8">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div id="header">
      <h2>Aventón</h2>
    </div>
    <div id="body">
      <h1>Bienvenido a Aventón!</h1>
      <div class="form_container">
        <h2>Iniciar sesión</h2>
        <form>
          <h3>Ingrese su mail:</h3>
          <input type="email" name="mail">
          <br>
          <h3>Ingrese su contraseña:</h3>
          <input type="password" name="password">
          <br><br>
          <input type="submit" text="Iniciar Sesión">
          <br><br>
          <a href="/php/recuperar_contraseña.php">Olvide mi contraseña!</a>
        </form>
      </div>
      <div class="form_container">
        <h2>Crear una cuenta</h2>
        <form>
          <h3>Ingrese su nombre completo:</h3>
          <input type="text" name="name">
          <br>
          <h3>Ingrese su mail:</h3>
          <input type="email" name="mail">
          <br>
          <h3>Ingrese su fecha de nacimiento:</h3>
          Día: 
          <select name="birth_day">
            <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
            <option>6</option><option>7</option><option>8</option><option>9</option><option>10</option>
            <option>11</option><option>12</option><option>13</option><option>14</option><option>15</option>
            <option>16</option><option>17</option><option>18</option><option>19</option><option>20</option>
            <option>21</option><option>22</option><option>23</option><option>24</option><option>25</option>
            <option>26</option><option>27</option><option>28</option><option>29</option><option>30</option>
            <option>31</option>
          </select>
           - Mes:
          <select name="birth_month">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
           - Año:
          <select name="birth_year">
            <option value="2000">2000</option>
            <option value="1999">1999</option>
            <option value="1998">1998</option>
            <option value="1997">1997</option>
            <option value="1996">1996</option>
            <option value="1995">1995</option>
            <option value="1994">1994</option>
            <option value="1993">1993</option>
            <option value="1992">1992</option>
            <option value="1991">1991</option>
            <option value="1990">1990</option>
            <option value="1989">1989</option>
          </select>
          <h3>Ingrese su contraseña:</h3>
          <input type="password" name="password">
          <br>
          <h3>Ingrese su contraseña nuevamente:</h3>
          <input type="password" name="password_confirmation">
          <br>
          <br>
          <input type="submit" text="Iniciar Sesión">
        </form>
      </div>
    </div>
    <div id="footer">
      <a id="help_link"  href="/php/ayuda.php">Ayuda y Contacto</a>
    </div>
  </body>
</html>
