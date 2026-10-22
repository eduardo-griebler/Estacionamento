<h2>Cadastrar veículo</h2>

<form action="" method="post">

        <label for="placa">Placa:</label>
        <input type="text" id="placa" name="placa" required>

        <br><br>

        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required>

        <br><br>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo" required>
                <option value="Carro">Carro</option>
                <option value="Moto">Moto</option>
        </select>

        <br><br>

        <button type="submit" name="acao" value="cadastrar_veiculo">
                Cadastrar veículo
        </button>

</form>