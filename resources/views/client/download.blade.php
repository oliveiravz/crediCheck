<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualização de Score de Crédito</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #f0f4f8, #d9d9d9); /* Degradê leve */
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .score-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }

        .score-title {
            font-size: 24px;
            color: #9408a7;
            margin-bottom: 10px;
        }

        .score-value {
            font-size: 48px;
            font-weight: bold;
            color: #9408a7;
            margin: 10px 0;
        }

        .score-description {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
        }

        .info-item {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 22%;
            text-align: center;
        }

        .chart-container {
            position: relative;
            margin: 20px auto;
            width: 80%;
            height: 300px;
        }

        .chart-legend {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .chart-legend div {
            margin: 0 10px;
            display: flex;
            align-items: center;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Score de Crédito de {{ $client['name'] }}</h1>

        <div class="score-card">
            <div class="score-title">Score de Crédito</div>
            <div class="score-value" id="scoreValue">{{ $client['score'] }}</div>
            <div class="score-description">
                @if ($client['score'] >= 700)
                    Seu score é considerado bom. Mantenha suas contas em dia para melhorar ainda mais!
                @else
                    Seu score é considerado abaixo da média. Tente manter suas contas em dia para melhorá-lo.
                @endif
            </div>
        </div>

        <div class="info">
            <div class="info-item">
                <h3>Escolaridade</h3>
                <p>{{ $client['education'] }}</p>
            </div>
            <div class="info-item">
                <h3>Salário</h3>
                <p>R$ {{ number_format($client['salary'], 2, ',', '.') }}</p>
            </div>
            <div class="info-item">
                <h3>Nº de Cartões</h3>
                <p>{{ $client['credit_cards'] }}</p>
            </div>
            <div class="info-item">
                <h3>Total de Dívidas</h3>
                <p>R$ {{ number_format($client['debts'], 2, ',', '.') }}</p>
            </div>
        </div>

        <div class="chart-container">
            <canvas id="gaugeChart"></canvas>
            <div class="chart-legend">
                <div><span class="legend-color" style="background-color: #9408a7;"></span> Score</div>
                <div><span class="legend-color" style="background-color: #e0e0e0;"></span> Restante</div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('gaugeChart').getContext('2d');
        const score = <?=$client['score']?>; // Score dinâmico vindo do servidor
        const maxScore = 1000; // Considerando o score máximo como 1000
        const gaugeChart = new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: ['Score', 'Restante'],
                datasets: [{
                    data: [score, maxScore - score], // Score e o restante até o máximo
                    backgroundColor: ['#9408a7', '#e0e0e0'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scale: {
                    ticks: {
                        beginAtZero: true,
                        suggestedMax: maxScore
                    }
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    legend: {
                        display: false // Esconder a legenda
                    }
                }
            }
        });

        // Adicionando um ponteiro ao gráfico
        const drawPointer = () => {
            const centerX = ctx.canvas.width / 2;
            const centerY = ctx.canvas.height / 2;
            const radius = Math.min(centerX, centerY) - 10; // Raio do gráfico

            // Cálculo do ângulo para o score
            const scoreAngle = (score / maxScore) * Math.PI; // Ângulo do ponteiro

            // Cálculo das coordenadas do ponteiro
            const pointerX = centerX + radius * Math.cos(scoreAngle - Math.PI / 2);
            const pointerY = centerY + radius * Math.sin(scoreAngle - Math.PI / 2);

            ctx.fillStyle = '#9408a7'; // Cor do ponteiro
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.lineTo(pointerX, pointerY);
            ctx.lineTo(centerX, centerY - 10); // Ponto superior do ponteiro
            ctx.closePath();
            ctx.fill();
        };

        // Desenha o gráfico e depois o ponteiro
        gaugeChart.update();
        drawPointer();
    </script>

</body>
</html>
