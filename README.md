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

### 2. Facade (Estrutural)

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

## Por que usar padrões de projeto?

Os padrões de projeto são fundamentais para criar sistemas robustos, organizados e escaláveis. Neste projeto, os padrões ajudam a:

- **Reduzir o acoplamento**: As classes podem ser modificadas ou substituídas sem impactar outras partes do sistema.
- **Melhorar a manutenção**: O código é modular e fácil de entender, facilitando futuras melhorias ou correções.
- **Promover a reutilização**: Componentes como o `PostFactory`, `PostLogger` e estratégias de validação podem ser reutilizados em outros projetos.

---

## Estrutura do Projeto

A estruturação das pastas está da seguinte forma:


A estruturação das pastas está da seguinte forma:

├── /css
│   └── geral.css                  # Estilos gerais do site
│
├── /js                            # Scripts JavaScript utilizados no site
│   ├── btnEditarPost.js  
│   ├── buscarPost.js  
│   ├── header.js  
│   └── notify.js           
│
├── /php                           # Scripts PHP que lidam com o backend
│   ├── /config
│   │   └── conexao.php            # Arquivo de conexão com o banco de dados
│   ├── /facade
│   │   └── PostManager.php        # Gerencia as operações relacionadas a posts
│   ├── /factory
│   │   ├── ImagePost.php          # Classe para posts de imagem
│   │   ├── Post.php               # Classe base para posts
│   │   ├── PostFactory.php        # Fábrica para criação de posts
│   │   ├── TextPost.php           # Classe para posts de texto
│   │   └── VideoPost.php          # Classe para posts de vídeo
│   ├── /observer
│   │   ├── PostLogger.php         # Implementação de log para posts
│   │   └── PostObserver.php       # Interface para Observers
│   ├── /strategy
│   │   ├── ImagePostStrategy.php  # Estratégia para posts de imagem
│   │   ├── PostStrategy.php       # Interface base para estratégias de posts
│   │   ├── TextPostStrategy.php   # Estratégia para posts de texto
│   │   └── VideoPostStrategy.php  # Estratégia para posts de vídeo
│   ├── createPost.php             # Lógica para criação de post
│   ├── editPost.php               # Lógica para editar post
│   ├── home.php                   # Página inicial
│   ├── readPost.php               # Lógica para exibição de post
│   └── post.php                   # Lógica central para posts
│
├── /uploads                       # Pasta onde serão armazenados os arquivos de mídia (imagens, vídeos)
├── /bancoDados.sql                # Arquivo SQL para o banco de dados
├── /apresentação.pdf              # Apresentação PDF
├── /README.md                     # Arquivo README com detalhes do projeto