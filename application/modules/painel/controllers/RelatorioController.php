<?php

/**
 *
 */
class Painel_RelatorioController extends Reverb_Controller_Action {
    /**
     *
     */
    public function init() {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8");
        date_default_timezone_set('America/Sao_Paulo');
    }

    /**
     *
     */
    public function indexAction() {

        $modelRelatorio = new Default_Model_Relatorio();

        if($this->_request->isPost()){

        }else{
            $modelProdutoCategoria = new Default_Model_Produtoscategoria();
            $dadosProdutoCategoria = $modelProdutoCategoria->fetchAll(array('DS_STATUS_PCRC = "A"'), array('DS_CATEGORIA_PCRC ASC'));
            $this->view->dadosTemas = $dadosProdutoCategoria;

            $modelTamanho = new Default_Model_Tamanhos();
            $dadosTamanho = $modelTamanho->fetchAll(array('DS_STATUS_TARC = "A"'), array('DS_TAMANHO_TARC ASC'));
            $this->view->dadosTamanho = $dadosTamanho;

            $selectRelatorio = $modelRelatorio->select()
                ->from(array('r' => 'relatorio'), array())
                ->columns(array(
                    'NR_SEQ_RELATORIO_RERC',
                    'DS_RELATORIO_RERC'
                ))
                ->order('NR_SEQ_RELATORIO_RERC DESC');
            $dadosRelatorio = $modelRelatorio->fetchAll($selectRelatorio);
            $this->view->dadosRelatorio = $dadosRelatorio;
        }
    }

    /**
     *
     */
    public function simplesGeradoAction(){
        $id = $this->_request->getParam('id');

        $modelRelatorio = new Default_Model_Relatorio();

        $messages = new Zend_Session_Namespace("messages");

        if(!empty($id)){
            $dadosRelatorio = $modelRelatorio->fetchRow(array('NR_SEQ_RELATORIO_RERC = ?' => $id));

            if($dadosRelatorio){
                // Tipo 1 é vendas
                if($dadosRelatorio->DS_TIPO_RERC == 1){
                    $modelCompras = new Default_Model_Compras();
                    $selectCompras = $modelCompras->select()
                        ->from(array('c' => 'compras'), array())
                        ->join(array('ce' => 'cestas'), 'NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO', array())
                        ->join(array('p' => 'produtos'), 'NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_CESO', array())
                        ->columns(array(
                            'NR_SEQ_COMPRA_COSO',
                            'DT_COMPRA_COSO',
                            'VL_TOTAL_COSO',
                            'VL_FRETE_COSO',
                            'VL_FRETECUSTO_COSO'
                        ))
                        ->where('DATE_FORMAT(c.DT_COMPRA_COSO, "%Y-%m-%d") >= ?', $dadosRelatorio->DT_INI_RERC)
                        ->where('DATE_FORMAT(c.DT_COMPRA_COSO, "%Y-%m-%d") <= ?', $dadosRelatorio->DT_FIM_RERC)
                        ->group('c.NR_SEQ_COMPRA_COSO');

                    if(!empty($dadosRelatorio->NR_SEQ_PRODUTO_CATEGORIA_RERC)){
                        $selectCompras->where('NR_SEQ_CATEGORIA_PRRC = ?', $dadosRelatorio->NR_SEQ_PRODUTO_CATEGORIA_RERC);
                    }

                    if($dadosRelatorio->NR_GENERO_RERC == 1){
                        $selectCompras->where('DS_GENERO_PRRC = "M"');
                    }elseif($dadosRelatorio->NR_GENERO_RERC == 2){
                        $selectCompras->where('DS_GENERO_PRRC = "F"');
                    }

                    if(!empty($dadosRelatorio->NR_SEQ_TAMANHO_RERC)){
                        $selectCompras->where('NR_SEQ_TAMANHO_CESO = ?', $dadosRelatorio->NR_SEQ_TAMANHO_RERC);
                    }

                    $dadosCompras = $modelCompras->fetchAll($selectCompras);
                    $this->view->dadosCompras = $dadosCompras;
                }
                $this->view->dadosRelatorio = $dadosRelatorio;
            }else{
                $messages->error = 'Relatório não encontrado.';
                $this->_redirect('/painel/relatorio');
            }
        }
    }

    /**
     *
     */
    public function comparativoAction(){

       $vendas1 = array();
       $vendas2 = array();
       $st = rand(1, 5);
       $max = -1;
       $min = 11111;

       $monthArray = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
       $this->view->monthArray = $monthArray;

       for($i = 1; $i <= 7; $i++){
           $a = rand(300, 600);
           $b = rand(300, 600);

           $vendas1[] = array(
               'data' => "01/" . str_pad($st, 2,  '0', STR_PAD_LEFT),
               'mon' => $st,
               'vendas' => $a
           );

           $vendas2[] = array(
               'data' => "01/" . str_pad($st, 2,  '0', STR_PAD_LEFT),
               'mon' => $st,
               'vendas' => $b
           );
           $st++;
           $max = max($a, $b, $max);
           $min = min($a, $b, $min);
       }
       $this->view->max = $max;
       $this->view->min = $min;
       
       $this->view->vendas1 = $vendas1;
       $this->view->vendas2 = $vendas2;
    }

    public function cadastrarRelatorioAction(){
        if($this->_request->isPost()){
            $dadosPost = $this->_request->getParams();

            $modelRelatorio = new Default_Model_Relatorio();

            $dadosPost['data_ini'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['data_ini'])));
            $dadosPost['data_fim'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['data_fim'])));

            $dataRelatorio = array(
                'DS_RELATORIO_RERC'                 => $dadosPost['titulo'],
                'DS_TIPO_RERC'                      => $dadosPost['tipo'],
                'DT_INI_RERC'                       => $dadosPost['data_ini'],
                'DT_FIM_RERC'                       => $dadosPost['data_fim'],
                'NR_SEQ_PRODUTO_CATEGORIA_RERC'     => $dadosPost['tema'] ? $dadosPost['tema'] : null,
                'NR_GENERO_RERC'                    => $dadosPost['genero'] ? $dadosPost['genero'] : null,
                'NR_SEQ_TAMANHO_RERC'               => $dadosPost['tamanho'] ? $dadosPost['tamanho'] : null
            );

            $modelRelatorio->insert($dataRelatorio);

            $this->_redirect('/painel/relatorio');
        }
    }

    public function excluirRelatorioAction(){
        $id = $this->_request->getParam('id');

        if(!empty($id)){
            $modelRelatorio = new Default_Model_Relatorio();

            $messages = new Zend_Session_Namespace("messages");

            try{
                $modelRelatorio->delete(array('NR_SEQ_RELATORIO_RERC = ?' => $id));

                $messages->success = 'Relatório excluido com sucesso.';
            }catch (Exception $e){
                $messages->error = 'Ocorreu um erro ao excluir o relatório.';
            }
        }

        $this->_redirect('/painel/relatorio');
    }

    public function editarRelatorioAction(){
        $id = $this->_request->getParam('id');

        $modelRelatorio = new Default_Model_Relatorio();

        $messages = new Zend_Session_Namespace("messages");

        if($this->_request->isPost()){
            $dadosPost = $this->_request->getParams();

            $dadosPost['data_ini'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['data_ini'])));
            $dadosPost['data_fim'] = date('Y-m-d', strtotime(str_replace('/', '-', $dadosPost['data_fim'])));

            $dataRelatorio = array(
                'DS_RELATORIO_RERC'                 => $dadosPost['titulo'],
                'DS_TIPO_RERC'                      => $dadosPost['tipo'],
                'DT_INI_RERC'                       => $dadosPost['data_ini'],
                'DT_FIM_RERC'                       => $dadosPost['data_fim'],
                'NR_SEQ_PRODUTO_CATEGORIA_RERC'     => $dadosPost['tema'] ? $dadosPost['tema'] : null,
                'NR_GENERO_RERC'                    => $dadosPost['genero'] ? $dadosPost['genero'] : null,
                'NR_SEQ_TAMANHO_RERC'               => $dadosPost['tamanho'] ? $dadosPost['tamanho'] : null
            );

            try{
                $modelRelatorio->update($dataRelatorio, array('NR_SEQ_RELATORIO_RERC = ?' => $id));

                $messages->success = 'Relatório editado com sucesso.';
            }catch (Exception $e){
                $messages->error = 'Ocorreu um erro ao editar o relatório.';
            }

            $this->_redirect('/painel/relatorio');
        }else{
            if(!empty($id)){
                $dadosRelatorio = $modelRelatorio->fetchRow(array('NR_SEQ_RELATORIO_RERC = ?' => $id));
                $this->view->dadosRelatorio = $dadosRelatorio;

                $modelProdutoCategoria = new Default_Model_Produtoscategoria();
                $dadosProdutoCategoria = $modelProdutoCategoria->fetchAll(array('DS_STATUS_PCRC = "A"'), array('DS_CATEGORIA_PCRC ASC'));
                $this->view->dadosTemas = $dadosProdutoCategoria;

                $modelTamanho = new Default_Model_Tamanhos();
                $dadosTamanho = $modelTamanho->fetchAll(array('DS_STATUS_TARC = "A"'), array('DS_TAMANHO_TARC ASC'));
                $this->view->dadosTamanho = $dadosTamanho;
            }
        }
    }

    public function vendasLiquidaAction(){
        $mes = $this->_request->getParam('mes');
        $ano = $this->_request->getParam('ano');

        $idCache = 'relatorio_vendas_'.$mes.'_'.$ano;
        $dadosCompra = Zend_Registry::get("cache")->load($idCache);
        if(!$dadosCompra){
            $modelCompras = new Default_Model_Compras();
            $selectCompras = $modelCompras->select()
                ->from(array('c' => 'compras'), array())
                ->columns(array(
                    'data'              =>'DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%d/%m/%Y")',
                    'total'             => 'SUM(c.VL_TOTAL_COSO)',
                    'totalFrete'        => 'SUM(c.VL_FRETE_COSO)',
                    'totalFreteCusto'   => 'SUM(c.VL_FRETECUSTO_COSO)',
                    'totalBoleto'       => '(SELECT SUM(VL_TOTAL_COSO) FROM compras c2 WHERE c2.DS_FORMAPGTO_COSO = "boleto" AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d"))',
                    'qtdBoleto'         => '(SELECT COUNT(*) FROM compras c2 WHERE c2.DS_FORMAPGTO_COSO = "boleto" AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d"))',
                    'totalCartao'       => '(SELECT SUM(VL_TOTAL_COSO) FROM compras c2 WHERE c2.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex") AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") AND c2.ST_COMPRA_COSO NOT IN ("C", "A"))',
                    'qtdCartao'         => '(SELECT COUNT(*) FROM compras c2 WHERE c2.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex") AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") AND c2.ST_COMPRA_COSO NOT IN ("C", "A"))',
                    'totalDinheiro'     => '(SELECT SUM(VL_TOTAL_COSO) FROM compras c2 WHERE c2.DS_FORMAPGTO_COSO = "dinheiro" AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") AND c2.ST_COMPRA_COSO NOT IN ("C", "A"))',
                    'qtdDinheiro'       => '(SELECT COUNT(*) FROM compras c2 WHERE c2.DS_FORMAPGTO_COSO = "dinheiro" AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") AND c2.ST_COMPRA_COSO NOT IN ("C", "A"))',
                    'qtdItens'          => '(SELECT SUM(NR_QTDE_CESO) FROM cestas ce2 INNER JOIN compras c2 ON c2.NR_SEQ_COMPRA_COSO = ce2.NR_SEQ_COMPRA_CESO WHERE c2.ST_COMPRA_COSO NOT IN ("C", "A") AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") )',
                    'qtdCamisetas'      => '(SELECT SUM(NR_QTDE_CESO) FROM cestas ce2 INNER JOIN compras c2 ON c2.NR_SEQ_COMPRA_COSO = ce2.NR_SEQ_COMPRA_CESO INNER JOIN produtos p2 ON p2.NR_SEQ_PRODUTO_PRRC = ce2.NR_SEQ_PRODUTO_CESO WHERE c2.ST_COMPRA_COSO NOT IN ("C", "A") AND DATE_FORMAT(c2.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") AND NR_SEQ_TIPO_PRRC = 6)'
                ))
                ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
                ->where('c.NR_SEQ_LOJA_COSO = ?', 1)
                ->where('c.NR_SEQ_CADASTRO_COSO NOT IN (8074, 6605, 22364)')
                ->where('YEAR(DT_PAGAMENTO_COSO) = ?', $ano)
                ->where('MONTH(DT_PAGAMENTO_COSO) = ?', $mes)
                ->group('DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d")')
                ->order('DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%d-%m")');
            $dadosCompra = $modelCompras->fetchAll($selectCompras)->toArray();

            Zend_Registry::get("cache")->save($dadosCompra, $idCache);
        }

        $this->view->mes = $mes;
        $this->view->ano = $ano;
        $this->view->dadosCompra = $dadosCompra;
    }

    public function conciliacaoAction(){
        $dia = $this->_request->getParam('dia');
        $mes = $this->_request->getParam('mes');
        $ano = $this->_request->getParam('ano');

        $data = $ano . '-' . $mes . '-' . $dia;

        $modelCompras = new Default_Model_Compras();

        //*********** BUSCA O VALOR BRUTO A RECEBER NO DIA ***********//
        $selectCompras1Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM(c.VL_TOTAL_COSO/c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 30 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 1)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $selectCompras2Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM(c.VL_TOTAL_COSO/c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 60 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 2)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $selectCompras3Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM(c.VL_TOTAL_COSO/c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 90 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 3)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $selectCompras4Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM(c.VL_TOTAL_COSO/c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 120 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 4)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $db = Zend_Registry::get("db");
        $subSelect = $db->select()
            ->union(array($selectCompras1Parcela, $selectCompras2Parcela, $selectCompras3Parcela, $selectCompras4Parcela))->__toString();

        $query = $db->query("SELECT SUM(vlTotal) as vlTotal FROM (".$subSelect.") as tmp");

        $dadosCompra = $query->fetchAll();
        $valorBrutoDiario = $dadosCompra[0]['vlTotal'];

        //*********** FIM - BUSCA O VALOR BRUTO A RECEBER NO DIA ***********//

        //*********** BUSCA O VALOR LÍQUIDO A RECEBER NO DIA ***********//
        $selectCompras1Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM((c.VL_TOTAL_COSO - (c.VL_TOTAL_COSO * (IF(c.NR_PARCELAS_COSO = 1, 0.03, 0.0326)))) / c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 30 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 1)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $selectCompras2Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM((c.VL_TOTAL_COSO - (c.VL_TOTAL_COSO * 0.0326)) / c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 60 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 2)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $selectCompras3Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM((c.VL_TOTAL_COSO - (c.VL_TOTAL_COSO * 0.0326)) / c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 90 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 3)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $selectCompras4Parcela = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlTotal' => 'SUM((c.VL_TOTAL_COSO - (c.VL_TOTAL_COSO * 0.0326)) / c.NR_PARCELAS_COSO)'
            ))
            ->where('(DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") = DATE_SUB(?, INTERVAL 120 day)', $data)
            ->where('c.NR_PARCELAS_COSO >= 4)')
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO IN ("visa", "mastercard", "amex")');

        $db = Zend_Registry::get("db");
        $subSelect = $db->select()
            ->union(array($selectCompras1Parcela, $selectCompras2Parcela, $selectCompras3Parcela, $selectCompras4Parcela))->__toString();

        $query = $db->query("SELECT SUM(vlTotal) as vlTotal FROM (".$subSelect.") as tmp");

        $dadosCompra = $query->fetchAll();
        $valorLiquidoDiario = $dadosCompra[0]['vlTotal'];

        //*********** FIM - BUSCA O VALOR LÍQUIDO A RECEBER NO DIA ***********//

        $start = new DateTime(date('Y-m-d', strtotime($data . ' + 1 day')) . ' 00:00:00');
        $end = new DateTime(date('Y-m-d', strtotime($data . ' + 4 month')) . ' 23:59:59');
        $interval = new DateInterval('P1D');
        $dateRange = new DatePeriod($start, $interval, $end);

        $weekNumber = 1;
        $weeks = array();
        foreach ($dateRange as $date) {
            $weeks[$weekNumber][] = $date->format('Y-m-d');
            if ($date->format('w') == 6) {
                $weekNumber++;
            }
            if($date->format('Y-m-d') == date('Y-m-d')){
                $currentWeekNumber = $weekNumber;
            }
        }

        $this->view->weeks = $weeks;

        $this->view->vlrLiquidoHoje = $valorLiquidoDiario;
        $this->view->vlrBrutoHoje = $valorBrutoDiario;

        $this->view->dia = $dia;
        $this->view->mes = $mes;
        $this->view->ano = $ano;
    }

    public function conciliacaoBoletoAction(){
        $mes = $this->_request->getParam('mes');
        $ano = $this->_request->getParam('ano');

        $modelCompras = new Default_Model_Compras();

        $selectCompras = $modelCompras->select()
            ->from(array('c' => 'compras'), array())
            ->columns(array(
                'vlr' => 'SUM(c.VL_TOTAL_COSO)',
                'qtd' => 'COUNT(*)',
                'data' => 'DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d")'
            ))
            ->where('c.ST_COMPRA_COSO NOT IN ("C", "A")')
            ->where('c.DS_FORMAPGTO_COSO = ?', 'boleto')
            ->where('DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") >= DATE_FORMAT(LAST_DAY("'.$ano.'-'.($mes-1).'-01") - ((7 + WEEKDAY(LAST_DAY("'.$ano.'-'.($mes-1).'-01")) - 4) % 7), "%Y-%m-%d")')
            ->where('DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d") <= DATE_ADD("'.$ano.'-'.($mes+1).'-01"  , INTERVAL ((6 - DAYOFWEEK("'.$ano.'-'.($mes+1).'-01") ) % 7 ) + 0 DAY)')
            ->group('DATE_FORMAT(c.DT_PAGAMENTO_COSO, "%Y-%m-%d")');
        $dadosCompra = $modelCompras->fetchAll($selectCompras)->toArray();

        $this->view->dadosCompras = $dadosCompra;
        $this->view->mes = $mes;
        $this->view->ano = $ano;
    }
}

