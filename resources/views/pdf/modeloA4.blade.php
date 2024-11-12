<!DOCTYPE html>
<html>
<head>
    <title>PDF Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20mm;
        }
        h3 {
            margin: 0;
            padding-bottom: 10px;
        }
        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<h3>Nome (Razão Social): {{ $nome }}</h3>
<p>Rua: {{ $rua }}</p>
<p>Numero: {{ $numero }}</p>
<p>Endereco: {{ $bairro }}, {{ $cidade }}</p>
<p>CEP: {{ $cep }}</p>
</body>
</html>
