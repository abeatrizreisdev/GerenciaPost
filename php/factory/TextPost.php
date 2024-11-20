<?php
require_once 'Post.php';

class TextPost extends Post {
    public $texto;

    public function __construct($texto) {
        $this->texto = $texto;
    }
    // Getter e Setter para 'texto'
    public function getTexto() {
        return $this->texto;
    }

    public function setTexto($conteudo) {
        $this->texto = $conteudo;
    }

    public function saveToDatabase() {
        try {
            // Obter a instância do banco de dados
            $db = Database::getInstance();
            
            // Inserir o post na tabela 'posts'
            $query = "INSERT INTO posts (tipo, texto, data_criacao, data_atualizacao) VALUES ('text', ?, NOW(), NOW())";
            $stmt = $db->prepare($query);
            
            // Executar a consulta com o URL da imagem
            $stmt->execute([$this->texto]);
    
            echo "Post salvo no banco de dados: " . $this->texto . "\n";
        } catch (Exception $e) {
            // Tratar possíveis erros
            echo "Erro ao salvar o post no banco de dados: " . $e->getMessage() . "\n";
        }
    }
    
    
}
