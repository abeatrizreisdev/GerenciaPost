<?php

interface ComissaoStrategy {
    public function calcular(float $venda): float;
}

class AtendenteComissao implements ComissaoStrategy {
    public function calcular(float $venda): float {
        return $venda * 0.01;
    }
}

class VendedorComissao implements ComissaoStrategy {
    public function calcular(float $venda): float {
        return $venda * 0.05;
    }
}

class GerenteComissao implements ComissaoStrategy {
    public function calcular(float $venda): float {
       
        $comissao = $venda * 0.02;
        if ($venda > 10000) {
            $comissao += 100;
        }
        return $comissao;
    }
}

class VendaFuncionario {
    private $comissaoStrategy;

    public function __construct(ComissaoStrategy $strategy) {
        $this->comissaoStrategy = $strategy;
    }

    public function pagamento(float $venda): float {
        return $this->comissaoStrategy->calcular($venda);
    }
}

?>