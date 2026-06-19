Relatório Técnico de Infraestrutura — Sistema EasyBarber

Este repositório contém a infraestrutura e os arquivos de configuração para o deploy do EasyBarber, um sistema moderno de gerenciamento e agendamento para barbearias. A arquitetura foi totalmente containerizada utilizando Docker e Docker Compose, visando portabilidade, segurança e alta disponibilidade.


1. Visão Geral da Arquitetura

A solução foi estruturada utilizando uma abordagem micro-segmentada, separando a camada de proxy/segurança, o servidor de aplicação web e o banco de dados em containers dedicados, interconectados por uma rede isolada.



┌────────────────────────────────────────────────────────┐
│                      REDE PÚBLICA                      │
└───────────────────────────┬────────────────────────────┘
│ (Portas 80 / 443)
▼
┌─────────────────────────┐
│   Nginx Proxy Manager   │
└────────────┬────────────┘
│ (Rede Interna: app_net)
▼
┌─────────────────────────┐
│    Servidor Apache      │ ◄──── [ Armazenamento NFS ]
└────────────┬────────────┘       (Persistência de Mídia)
│
▼
┌─────────────────────────┐
│        MySQL 8.0        │
└─────────────────────────┘




2. Configuração do Servidor Web & Aplicação

A camada web foi desenhada com foco em performance e capacidade de reescrita de rotas para APIs amigáveis.

Dockerfile da Aplicação (`php:8.2-apache`)
 Servidor de Produção: Apache com os módulos `rewrite` e `headers` habilitados de forma nativa.
 Diretivas de Segurança: Configuração do `AllowOverride All` para validação dinâmica via arquivos `.htaccess`.

 Otimização do Core PHP: Instalação e compilação de extensões essenciais para o ecossistema do EasyBarber:
  `opcache`: Cache de bytecode para aceleração de scripts PHP.
  `gd` & `intl`: Manipulação avançada de imagens (processamento de fotos de perfis/cortes) e internacionalização de datas.
 `pdo_mysql` & `mysqli`: Drivers nativos e otimizados para comunicação com o banco de dados.

Proxy Reverso & Certificados SSL

O container `nginx-proxy-manager` atua como a borda da infraestrutura:
 Concentra o tráfego externo nas portas padrão 80 (HTTP) e 443 (HTTPS).
 Realiza o roteamento transparente para o container Apache (rodando internamente na porta `8050`).
 Gerencia de forma automatizada a renovação de certificados criptográficos via **Let's Encrypt.


3. Persistência de Dados & Infraestrutura NFS

Para blindar o sistema contra perda de dados de uploads de usuários, agendamentos e mídias do EasyBarber, o ecossistema de storage foi dividido em duas camadas:

| Componente | Tipo de Armazenamento | Ponto de Montagem Interno | Descrição |
| :--- | :--- | :--- | :--- |

| Banco de Dados | Volume Docker Dedicado | `/var/lib/mysql` | Armazena de forma persistente os dados relacionais do `mysql_data`. |

| Arquivos de Mídia | NFS (Network File System) | `/var/www/html` | Armazenamento de arquivos anexados e código-fonte espelhado em storage externo. |

Estruturação do Serviço de Arquivos (NFS)

1. Centralização: O diretório de uploads e arquivos estáticos fica fisicamente hospedado em um servidor de Storage NFS dedicado na rede local.


2. Resiliência: O host onde o Docker reside monta o compartilhamento de rede NFS. O Docker Compose lê esse ponto de montagem e o injeta diretamente no container Apache.


3. Segurança: Caso o container web precise ser reiniciado, atualizado ou recriado, os uploads dos clientes da barbearia permanecem intactos e centralizados.


4. Banco de Dados & Ferramentas de Administração

 Engine: `MySQL 8.0` configurado nativamente com o plugin de autenticação clássico para garantir retrocompatibilidade com os drivers PHP.

 Automação de Inicialização: Mapeamento do script estrutural `projeto.sql` no diretório `/docker-entrypoint-initdb.d/`. O banco é populado automaticamente no primeiro deploy (`cold start`).

 Healthcheck Activo: O container do banco possui verificação de saúde contínua executando `mysqladmin ping` a cada 5 segundos para garantir que o Apache só inicie após o banco estar 100% pronto.

 Painel Administrativo: Instalação do `phpMyAdmin` exposto de forma isolada na porta `8051` para gerência de tabelas e queries do sistema.


5. Topologia de Rede

A segurança a nível de rede é garantida através do driver `bridge` do Docker, criando a subnet isolada 'app_net'.

 Nginx Proxy Manager: Possui exposição pública (Portas '80', '443', '81').
 Apache / MySQL / phpMyAdmin: Ficam protegidos dentro da rede interna. O acesso direto do mundo externo ao banco de dados é completamente bloqueado, permitindo apenas conexões originadas de dentro da própria malha de containers.

