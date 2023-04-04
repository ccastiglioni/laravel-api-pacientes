# Descrição como Rodar:
- 1 dar um stop no apache e mysql da maquina local
- 2 docker compose build
- 3 docker compose up -d 
- 4 Logo ao subir o Projeto em http://localhost:8000/ estão as Instrições para Rodar a Migrate,As Seeders e a Factory
- 5 Depois é só usar O Insomnia para fazer os testes.

## Requisitos

Sua aplicação deve:

- Obrigatoriamente para o desenvolvimento do back-end utilizar o framework Laravel :heavy_check_mark:	
- Obrigatoriamente a API deve estar nos padrões RESTful.  :heavy_check_mark:
- Desenvolver uma listagem de pacientes com busca, do qual deve-se permitir a adição, edição, visualização e exclusão de cada um dos pacientes. :heavy_check_mark:	 
- Cada paciente deve ter um endereço cadastrado em uma tabela à parte. :heavy_check_mark:
- Utilizar para banco de dados PostgreSQL e Redis (Cache e Queue). **Aqui usei Mysql** :heavy_check_mark:
- Utilizar migration, factory, faker e seeder. :heavy_check_mark:	
- Criar um endpoint para listagem onde seja possível consultar pacientes pelo nome ou CPF. :heavy_check_mark:
- Criar um endpoint para obter os dados de um único pacientes (paciente e seu endereço). :heavy_check_mark:
- Criar endpoints de cadastro e atualização de paciente, contendo os campos e suas respectivas validações (Obs: use tudo que o framework(Laravel) te oferece para não criar códigos repetidos e desnecessários):
  - Foto do Paciente;
  - Nome Completo do Paciente;
  - Nome Completo da Mãe;
  - Data de Nascimento;
  - CPF;
  - CNS;
  - Endereço completo, (CEP, Endereço, Número, Complemento, Bairro, Cidade e Estado)*; :heavy_check_mark:
 - Criar um endpoint para excluir um paciente (paciente e seu endereço). :heavy_check_mark:
 - Criar um endpoint para consulta de CEP que implemente a API do ViaCEP e faça cache (Redis) dos dados para futuras consultas. **Usei um tempo de Cache de 15 e uma key Cache para visuzalizar o teste** :heavy_check_mark:
 - Criar um endpoint que faça importação de dados (pacientes) via arquivo .csv e seja processada em queue **assincronamente**.
 - Utilizar docker e docker-compose para execução do projeto (queremos avaliar seu conhecimento, seja criativo e não use o Laravel Sail). :heavy_check_mark:	

## Diferenciais que você pode entregar no seu projeto:
  - Utilizar algum padrão para commits; :heavy_check_mark:	
  - Possuir cobertura de testes unitários de 80% do código (*PHP Unit*);
  - Integrar a aplicação ao *Laravel Horizon* para o monitoramento das *queues*;
  - Utilizar o *supervisord* para o gerenciamento dos serviços necessários para o desenvolvimento e a execução do projeto;
  - Utilizar elasticsearch para busca otimizada de pacientes;
  - Paginar a listagem de pacientes;
