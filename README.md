Framework
=========

Framework de Recomendação para Lojas Virtuais
=========
Objetivo: Construir um framework genérico de recomendação de produtos para lojas virtuais.

<br>

Passo-a-Passo de instalação e utilização:

1º Passo: Abra o arquivo 'dados_conexao.php' e altere os campos "BD_Servidor", "BD_Usuario", "BD_Senha" para os dados correspondentes ao banco de dados de seu servidor.

2º Passo: Copie a pasta toda para o servidor da loja virtual. Lembre-se que onde colocar a pasta será o endereço para acessar o framework depois. Por exemplo: www.lojavirtual.com.br/framework

3º Passo: Acesse o endereço do framework, exemplo: www.lojavirtual.com.br/framework, e faça login (login: admin senha: admin).

4º Passo: Acesse a página "Configurações" através do menu lateral e preencha os campos correspondentes ao banco de dados da loja virtual. Clique no botão salvar para gravar as informações.

5º Passo: Chamando a função de recomendações na sua loja virtual:
No PHP chame o arquivo "recomende.php" com a chamada: require_once("bd_funcoes.php");
Após isto chame a função "Recomende" passando como parâmetro o código do cliente e a quantidade de recomendações que deseja receber. Como no exemplo: Recomende(1, 4);
Isso irá retornar um array com os 4 produtos recomendados pelo framework.
