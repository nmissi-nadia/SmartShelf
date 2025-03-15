<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alerte de Stock Critique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Alerte de Stock Critique</h1>
        <p>Bonjour,</p>
        <p>Nous vous informons que le produit <strong>{{ $produit->nom }}</strong> a atteint un seuil critique de stock.</p>
        <p>Quantité actuelle : <strong>{{ $produit->quantite }}</strong></p>
        <p>Veuillez prendre les mesures nécessaires pour réapprovisionner le stock.</p>
        <p>Merci,</p>
        <div class="footer">
            <p>Cette notification a été générée automatiquement.</p>
        </div>
    </div>
</body>
</html>