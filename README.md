# GerenciaPost

## Padrões de Projeto Implementados

Este projeto utiliza quatro padrões de projeto principais para organizar e estruturar o código de forma eficiente, escalável e fácil de manter. Além disso, conta com um singleton no banco de dados. Abaixo está uma descrição de cada padrão e como ele foi aplicado:

### 1. Factory Method (Criação)

**Função**: O padrão **Factory Method** é utilizado para criar objetos de maneira flexível e dinâmica, permitindo que o código seja independente das classes concretas que estão sendo instanciadas.

**Implementação no projeto**:
- A classe `PostFactory` é responsável por criar diferentes tipos de posts, como `TextPost`, `ImagePost` e `VideoPost`.
- A escolha do tipo de post é feita em tempo de execução, garantindo que o sistema possa ser facilmente estendido para novos tipos de posts no futuro.

**Benefício**: Promove a reutilização de código e reduz o acoplamento entre as classes concretas.

---

### 2. Façade (Estrutural)

**Função**: O padrão **Facade** fornece uma interface simplificada para interações complexas entre classes ou subsistemas, escondendo a complexidade do backend para quem usa o frontend.

**Implementação no projeto**:
- A classe `PostManager` atua como uma fachada, combinando as funcionalidades do **Factory Method**, das estratégias de validação e das operações de banco de dados em uma interface única e simples.
- Essa classe é usada para facilitar as operações relacionadas à criação, atualização, exclusão e exibição de posts.

**Benefício**: Simplifica a integração entre frontend e backend e melhora a legibilidade do código.

---

### 3. Observer (Comportamental)

**Função**: O padrão **Observer** é utilizado para notificar outros componentes do sistema sobre mudanças em um objeto de interesse, promovendo um sistema de eventos desacoplado.

**Implementação no projeto**:
- A interface `PostObserver` define a estrutura básica para observadores.
- A classe `PostLogger` implementa essa interface e é notificada sempre que um post é criado, atualizado ou excluído, registrando os eventos em um log.

**Benefício**: Permite adicionar novos comportamentos (como notificações ou auditorias) sem alterar as classes principais do sistema.

---

### 4. Strategy (Comportamental)

**Função**: O padrão **Strategy** permite definir diferentes algoritmos ou comportamentos e selecioná-los em tempo de execução, dependendo do contexto.

**Implementação no projeto**:
- A interface `PostStrategy` define a estrutura para estratégias de validação e exibição de posts.
- Classes como `TextPostStrategy`, `ImagePostStrategy` e `VideoPostStrategy` implementam comportamentos específicos para cada tipo de post.
- Cada tipo de post utiliza a estratégia correspondente para validar ou exibir seus dados de forma personalizada.

**Benefício**: Facilita a extensão do sistema para novos comportamentos sem modificar o código existente.

---

### 5. Singleton (Criação)
**Função**: É aplicado à classe `Database`, garante que haja apenas uma instância da classe e, consequentemente, uma única conexão com o banco de dados.

**Implementação no projeto**:
- O método getInstance() retorna a única instância da classe Database.
- Os métodos __clone() e __wakeup() previnem a clonagem da instância, respectivamente. Esses métodos são privados e vazios, impedindo que novas instâncias sejam criadas a partir da existente.
**Benefício**: Evita a abertura de múltiplas conexões, otimizando recursos e evitando sobrecarga no banco de dados.


## Por que usar padrões de projeto?

Os padrões de projeto são fundamentais para criar sistemas robustos, organizados e escaláveis. Neste projeto, os padrões ajudam a:

- **Reduzir o acoplamento**: As classes podem ser modificadas ou substituídas sem impactar outras partes do sistema.
- **Melhorar a manutenção**: O código é modular e fácil de entender, facilitando futuras melhorias ou correções.
- **Promover a reutilização**: Componentes como o `PostFactory`, `PostLogger` e estratégias de validação podem ser reutilizados em outros projetos.

---

## Estrutura do Projeto

O projeto está organizado nas seguintes pastas e arquivos:

### 1. **/css**  
   Contém os arquivos de estilo do site.
   - `geral.css`: Estilos gerais que definem a aparência do site.

### 2. **/js**  
   Contém os arquivos JavaScript utilizados para a interatividade e funcionalidades do frontend.
   - `btnEditarPost.js`: Script para a edição de posts.
   - `buscarPost.js`: Script para buscar posts.
   - `header.js`: Script responsável pelo cabeçalho da página.
   - `notify.js`: Script para notificações do sistema.

### 3. **/php**  
   Contém os arquivos PHP que gerenciam a lógica do backend, incluindo a interação com o banco de dados e as operações de post.
   
   - **/config**
     - `conexao.php`: Arquivo de configuração responsável pela conexão com o banco de dados.
   
   - **/facade**
     - `PostManager.php`: Implementa a lógica para gerenciar posts (criação, edição, exclusão, etc.) e atua como a fachada do sistema.

   - **/factory**
     - `ImagePost.php`: Classe que define a lógica para posts de imagem.
     - `Post.php`: Classe base para os posts.
     - `PostFactory.php`: Fábrica que cria instâncias de diferentes tipos de posts.
     - `TextPost.php`: Classe que define a lógica para posts de texto.
     - `VideoPost.php`: Classe que define a lógica para posts de vídeo.

   - **/observer**
     - `PostLogger.php`: Implementa o padrão Observer para registrar eventos relacionados aos posts (como criação, edição, etc.).
     - `PostObserver.php`: Interface que define o padrão Observer para monitoramento de alterações em posts.

   - **/strategy**
     - `ImagePostStrategy.php`: Define a estratégia de validação e exibição para posts de imagem.
     - `PostStrategy.php`: Interface base para as estratégias de posts.
     - `TextPostStrategy.php`: Define a estratégia de validação e exibição para posts de texto.
     - `VideoPostStrategy.php`: Define a estratégia de validação e exibição para posts de vídeo.

   - Arquivos principais:
     - `createPost.php`: Lógica para criação de um novo post.
     - `editPost.php`: Lógica para edição de um post existente.
     - `home.php`: Página inicial do projeto.
     - `readPost.php`: Lógica para exibição de um post.
     - `post.php`: Arquivo central de operações relacionadas a posts.

### 4. **/uploads**  
   Pasta onde são armazenados os arquivos de mídia (como imagens e vídeos) relacionados aos posts.

### 5. **/bancoDados.sql**  
   Arquivo SQL utilizado para criar o banco de dados e tabelas necessárias para o funcionamento do sistema.

### 6. **/apresentação.pdf**  
   Apresentação do projeto em formato PDF.

### 7. **/README.md**  
   Arquivo README com informações gerais sobre o projeto, como sua funcionalidade e detalhes de implementação.

---
