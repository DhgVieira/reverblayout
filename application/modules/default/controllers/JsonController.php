<?php

/**
 *
 */
class JsonController extends Zend_Controller_Action {
    /**
     *
     */
    public function init() {
        /* Initialize action controller here */
    }


    /**
     * Função responsavel por listas as imagens do detalhe do me
     */
    public function listafotosAction() {
        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 9);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");

        //crio a listagem de imagens
        $model_perfil = new Default_Model_Reverbme();

        if ($info) {
            //crio a query para selecionar os amigos
            $select_fotos = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            '')
                //crio o inner join dos comentarios
                ->joinInner('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            '')
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $usuarios->idperfil)
                ->group("NR_SEQ_FOTO_MCRC");
        } else {
            //crio a query
            $select_fotos = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO'))
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_MCRC)
                                           FROM me_fotos_coments
                                           WHERE me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $usuarios->idperfil)
                //ordeno pela data de envio
                ->order("me_fotos.DT_CADASTRO_FORC DESC")
                 ->group("NR_SEQ_FOTO_MCRC")
                ->limit($size, $start);
        }
        // crio a lista
        $fotos = $model_perfil->fetchAll($select_fotos);

        if ($info) {
            $fotos = array(
                'TOTAL_ITEMS'   => (int) $fotos[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $fotos = $fotos->toArray();
        }

        //crio o json
        $this->_helper->json($fotos);
    }


    /**
     * Função responsavel por listas os videos do detalhe do me
     */
    public function listavideosAction() {
        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 4);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio o model de videos
        $model_videos = new Default_Model_Mevideos();
        if ($info) {
            //crio o select de recados
            $select_videos = $model_videos
                ->select()
                ->from('me_videos', 'COUNT(*) AS TOTAL')
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $usuarios->idperfil)
                ->group("NR_SEQ_VIDEO_VIRC")
                ->order("DT_CADASTRO_VIRC DESC");
        } else {
            //crio o select de recados
            $select_videos = $model_videos
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_VIRC DESC")
                ->limit($size, $start)
                ->group("NR_SEQ_VIDEO_VIRC")
                ->order("DT_CADASTRO_VIRC DESC");
        }
        //crio a lista
        $videos = $model_videos->fetchAll($select_videos);

        if ($info) {
            $videos = array(
                'TOTAL_ITEMS'   => (int) $videos[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $videos = $videos->toArray();
        }

        //crio o json
        $this->_helper->json($videos);
    }


    /**
     * Função responsavel por listas os videos do detalhe do me
     */
    public function listapostsAction() {
        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 3);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio o model de blog
        $model_post = new Default_Model_Reverbmeblog();

        if ($info) {
            //crio o select de post
            $select_post = $model_post
                ->select()
                ->from('me_blog', 'COUNT(*) AS TOTAL')
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $usuarios->idperfil)
                 ->group("idme_blog");
        } else {
            //crio o select de post
            $select_post = $model_post
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("data_publicacao DESC")
                 ->group("idme_blog")
                ->limit($size, $start);
        }
        //crio a lista
        $posts = $model_post->fetchAll($select_post);

        if ($info) {
            $posts = array(
                'TOTAL_ITEMS'   => (int) $posts[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $posts = $posts->toArray();
        }

        //crio o json
        $this->_helper->json($posts);
    }


    /**
     * Função responsavel por listas os amigos do detalhe do me
     */
    public function listaamigosAction() {
        $info   = (bool) $this->_request->getParam("info", false);
        $start  = (int)  $this->_request->getParam("start", 0);
        $size   = (int)  $this->_request->getParam("size", 8);
        $filter = $this->_request->getParam("filter", "");

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");
        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        if ($info) {
            // crio a query para calcular quantidade de amigos
            // não sei por que não funciona count(*) nesse select.. o join deve estar errado..
            $select_amigos = "SELECT 1 AS ITEM
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $usuarios->idperfil
                                     ";
            if ($filter != "") {
                $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%") . "";
            }
            $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO
            ORDER BY DT_ACESSO_CASO DESC";
        } else {
            //crio a query para selecionar os amigos
            $select_amigos = "SELECT NR_SEQ_CADASTRO_CASO,
                                     DS_NOME_CASO,
                                     NR_SEQ_FRIEND_FRRC,
                                     NR_SEQ_AMIGO_FRRC,
                                     DS_EXT_CACH
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $usuarios->idperfil
                                    ";
            if ($filter != "") {
                $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%") . "";
            }
            $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO
                                ORDER BY DT_ACESSO_CASO DESC
                                LIMIT $size OFFSET $start";
        }

        // Monta a query
        $query = $db->query($select_amigos);
        //crio uma lista de amigos
        $lista = $query->fetchAll();

        if ($info) {
            $lista = array(
                'TOTAL_ITEMS'   => count($lista),
                'ITEMS_BY_PAGE' => $size
            );
        }

        //crio o json
        $this->_helper->json($lista);
    }


    /**
     * Função responsavel por listas os recados do detalhe do me
     */
    public function listarecadosAction() {
        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 5);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");

        //inicio o model de recados
        $model_scraps = new Default_Model_Mescraps();
        //crio o select de recados

        if ($info) {
            $select_scrap = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            '')
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $usuarios->idperfil)
                 ->group("NR_SEQ_SCRAP_SBRC");
        } else {
            $select_scrap = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO', 'DS_EXT_CACH'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_POST_SBRC DESC")
                ->group("NR_SEQ_SCRAP_SBRC")
                ->limit($size, $start);
        }
        //crio a lista
        $recados = $model_scraps->fetchAll($select_scrap);

        if ($info) {
            $recados = array(
                'TOTAL_ITEMS'   => (int) $recados[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $recados = $recados->toArray();
        }

        //crio o json
        $this->_helper->json($recados);
    }


    /**
     * Função responsavel por listas os wishlists do detalhe do me
     */
    public function listarwishlistAction() {
        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 6);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");

        //crio o model de wishlist
        $wishlist_model = new Default_Model_Wishlist();
        if ($info) {
            //crio a query da wishlist
            $select_wishlist = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $usuarios->idperfil)
                ->group("NR_SEQ_WISHLIST_WLRC");
        } else {
            //crio a query da wishlist
            $select_wishlist = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',
                            array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_WLRC DESC")
                 ->group("NR_SEQ_WISHLIST_WLRC")
                ->limit($size, $start);
        }
        ///crio a lista
        $recados = $wishlist_model->fetchAll($select_wishlist);

        if ($info) {
            $recados = array(
                'TOTAL_ITEMS'   => (int) $recados[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $recados = $recados->toArray();
        }

        //crio o json
        $this->_helper->json($recados);
    }


    /**
     * Função responsavel por listas os cycles do detalhe do me
     */
    public function listarcycleAction() {
        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 9);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");

        //crio o model de reverbcycle
        $model_cycle = new Default_Model_Reverbcycle();

        if ($info) {
            //crio a query do reverbcycle
            $select_cycle = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            '')
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $usuarios->idperfil)
                 ->group("NR_SEQ_REVERBCYCLE_RCRC");
        } else {
            //crio a query do reverbcycle
            $select_cycle = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_CRRC)
                                           FROM reverbcycle_coments
                                           WHERE reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $usuarios->idperfil)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_RCRC DESC")
                ->group("NR_SEQ_REVERBCYCLE_RCRC")
                ->limit($size, $start);
        }
        //crio a lista
        $cycles = $model_cycle->fetchAll($select_cycle);

        if ($info) {
            $cycles = array(
                'TOTAL_ITEMS'   => (int) $cycles[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $cycles = $cycles->toArray();
        }

        //crio o json
        $this->_helper->json($cycles);
    }

    /**
    * Função responsável por fazer a busca auto complete no usuário logado
    **/

    public function autocompleteamigoAction(){

        $filter = $this->_request->getParam("filter", "");

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");
        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        $select_amigos = "SELECT DS_NOME_CASO
                                 FROM me_friends,
                                      cadastros
                                 WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                       NR_SEQ_CADASTRO_FRRC = $usuarios->idperfil";
        if($filter){
            $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%")." ";
        }
         $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO

                                ORDER BY DT_ACESSO_CASO DESC
                                LIMIT 50";

        // Monta a query
        $query = $db->query($select_amigos);
        //crio uma lista de amigos
        $lista_amigos = $query->fetchAll();

        // recupera apenas os titulos
        foreach ($lista_amigos as $key => $value) {
            //assino o valor de nome
            $json_value[$key] = $value['DS_NOME_CASO'];

        }


        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value,0,13);

        //assino ao view o resultado
        $this->_helper->json($json_value);

    }


    //                                      //
    //                                      //
    // Agora vou criar os jsons do perfil   //
    //                                      //
    //                                      //

    /**
     * Função responsavel por listas as fotos do detalhe do perfil
     */
    public function listarfotosperfilAction() {
        //pego o perfil do usuário
        $idusuario = $this->_request->getParam("idperfil");

        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 9);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");

        //crio a listagem de imagens
        $model_perfil = new Default_Model_Reverbme();

        if ($info) {
            //crio a query para selecionar os amigos
            $select_fotos = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            '')
                //crio o inner join dos comentarios
                ->joinInner('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            '')
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $idusuario)
                ->group("NR_SEQ_FOTO_MCRC");
        } else {
            //crio a query
            $select_fotos = $model_perfil
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('cadastros',
                       array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO'))
                //crio o inner join das pessoas
                ->joinInner('me_fotos',
                            'me_fotos.NR_SEQ_CADASTRO_FORC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('me_fotos_coments',
                            'me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_MCRC)
                                           FROM me_fotos_coments
                                           WHERE me_fotos_coments.NR_SEQ_FOTO_MCRC = me_fotos.NR_SEQ_FOTO_FORC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_fotos.NR_SEQ_CADASTRO_FORC = ?", $idusuario)
                //ordeno pela data de envio
                ->order("me_fotos.DT_CADASTRO_FORC DESC")
                 ->group("NR_SEQ_FOTO_MCRC")
                ->limit($size, $start);
        }
        // crio a lista
        $fotos = $model_perfil->fetchAll($select_fotos);

        if ($info) {
            $fotos = array(
                'TOTAL_ITEMS'   => (int) $fotos[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $fotos = $fotos->toArray();
        }

        //crio o json
        $this->_helper->json($fotos);

        // die($select_fotos);
    }


    /**
     * Função responsavel por listas os videos do detalhe do perfil
     */
    public function listarvideosperfilAction() {
        //pego o perfil do usuário
        $idusuario = $this->_request->getParam("idperfil");

        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 4);

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");
        //inicio o model de videos
        $model_videos = new Default_Model_Mevideos();
        if ($info) {
            //crio o select de recados
            $select_videos = $model_videos
                ->select()
                ->from('me_videos', 'COUNT(*) AS TOTAL')
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $idusuario)
                ->group("NR_SEQ_VIDEO_VIRC")
                ->order("DT_CADASTRO_VIRC DESC");
        } else {
            //crio o select de recados
            $select_videos = $model_videos
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("NR_SEQ_CADASTRO_VIRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_VIRC DESC")
                ->limit($size, $start)
                ->group("NR_SEQ_VIDEO_VIRC")
                ->order("DT_CADASTRO_VIRC DESC");
        }
        //crio a lista
        $videos = $model_videos->fetchAll($select_videos);

        if ($info) {
            $videos = array(
                'TOTAL_ITEMS'   => (int) $videos[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $videos = $videos->toArray();
        }

        //crio o json
        $this->_helper->json($videos);

    }


    /**
     * Função responsavel por listas os amigos do detalhe do perfil
     */
    public function listaramigosperfilAction() {
        //pego o perfil do usuário
        $idusuario = $this->_request->getParam("idperfil");

        $info   = (bool) $this->_request->getParam("info", false);
        $start  = (int)  $this->_request->getParam("start", 0);
        $size   = (int)  $this->_request->getParam("size", 8);
        $filter = $this->_request->getParam("filter", "");
        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        if ($info) {
            // crio a query para calcular quantidade de amigos
            // não sei por que não funciona count(*) nesse select.. o join deve estar errado..
            $select_amigos = "SELECT 1 AS ITEM
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $idusuario
                                     ";
            if ($filter != "") {
                $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%") . "";
            }
            $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO
            ORDER BY DT_ACESSO_CASO DESC";
        } else {
            //crio a query para selecionar os amigos
            $select_amigos = "SELECT NR_SEQ_CADASTRO_CASO,
                                     DS_NOME_CASO,
                                     NR_SEQ_FRIEND_FRRC,
                                     NR_SEQ_AMIGO_FRRC,
                                     DS_EXT_CACH
                                     FROM me_friends,
                                          cadastros
                                     WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                           NR_SEQ_CADASTRO_FRRC = $idusuario
                                    ";
            if ($filter != "") {
                $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%") . "";
            }
            $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO
                                ORDER BY DT_ACESSO_CASO DESC
                                LIMIT $size OFFSET $start";
        }

        // Monta a query
        $query = $db->query($select_amigos);
        //crio uma lista de amigos
        $lista = $query->fetchAll();

        if ($info) {
            $lista = array(
                'TOTAL_ITEMS'   => count($lista),
                'ITEMS_BY_PAGE' => $size
            );
        }

        //crio o json
        $this->_helper->json($lista);
    }


    /**
     * Função responsavel por listas os recados do detalhe do perfil
     */
    public function listarrecadosperfilAction() {
        //pego o perfil do usuário
        $idusuario = $this->_request->getParam("idperfil");

        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 5);

        //inicio o model de recados
        $model_scraps = new Default_Model_Mescraps();
        //crio o select de recados

        if ($info) {
            $select_scrap = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            '')
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $idusuario)
                 ->group("NR_SEQ_SCRAP_SBRC");
        } else {
            $select_scrap = $model_scraps
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_scraps')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'me_scraps.NR_SEQ_AUTOR_SBRC = cadastros.NR_SEQ_CADASTRO_CASO',
                            array('NR_SEQ_CADASTRO_CASO','DS_NOME_CASO', 'DS_EXT_CACH'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_scraps.NR_SEQ_CADASTRO_SBRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_POST_SBRC DESC")
                ->group("NR_SEQ_SCRAP_SBRC")
                ->limit($size, $start);
        }
        //crio a lista
        $recados = $model_scraps->fetchAll($select_scrap);

        if ($info) {
            $recados = array(
                'TOTAL_ITEMS'   => (int) $recados[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $recados = $recados->toArray();
        }

        //crio o json
        $this->_helper->json($recados);
    }


    /**
     * Função responsavel por listas os recados do detalhe do perfil
     */
    public function listarwishlistperfilAction() {

        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 6);

       //pego o perfil do usuário
        $idusuario = $this->_request->getParam("idperfil");


        //crio o model de wishlist
        $wishlist_model = new Default_Model_Wishlist();
        if ($info) {
            //crio a query da wishlist
            $select_wishlist = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $idusuario)
                ->group("NR_SEQ_WISHLIST_WLRC");
        } else {
            //crio a query da wishlist
            $select_wishlist = $wishlist_model
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('me_wishlist')
                //crio o inner join das pessoas
                ->joinInner('produtos',
                            'me_wishlist.NR_SEQ_PRODUTO_WLRC = produtos.NR_SEQ_PRODUTO_PRRC',
                            array('*'))
                //onde os recados pertencerem apenas a pessoa
                ->where("me_wishlist.NR_SEQ_CADASTRO_WLRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_WLRC DESC")
                 ->group("NR_SEQ_WISHLIST_WLRC")
                ->limit($size, $start);
        }
        ///crio a lista
        $recados = $wishlist_model->fetchAll($select_wishlist);

        if ($info) {
            $recados = array(
                'TOTAL_ITEMS'   => (int) $recados[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $recados = $recados->toArray();
        }

        //crio o json
        $this->_helper->json($recados);
    }


/**
 * Função responsavel por listas os cycles do detalhe do perfil
 */
    public function listarcycleperfilAction() {
        //pego o perfil do usuário
        $idusuario = $this->_request->getParam("idperfil");

        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 9);
        //crio o model de reverbcycle
        $model_cycle = new Default_Model_Reverbcycle();

        if ($info) {
            //crio a query do reverbcycle
            $select_cycle = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle',
                       'COUNT(*) AS TOTAL')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            '')
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $idusuario)
                 ->group("NR_SEQ_REVERBCYCLE_RCRC");
        } else {
            //crio a query do reverbcycle
            $select_cycle = $model_cycle
                ->select()
                //digo que nao existe integridade entre as tabelas
                ->setIntegrityCheck(false)
                //escolho a tabela do select para o join
                ->from('reverbcycle')
                //crio o inner join das pessoas
                ->joinInner('cadastros',
                            'cadastros.NR_SEQ_CADASTRO_CASO = reverbcycle.NR_SEQ_CADASTRO_RCRC',
                            array('*'))
                //crio o inner join dos comentarios
                ->joinInner('reverbcycle_coments',
                            'reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC',
                            array('total_coments' =>
                                  '(SELECT COUNT(NR_SEQ_COMENTARIO_CRRC)
                                           FROM reverbcycle_coments
                                           WHERE reverbcycle_coments.NR_SEQ_COMENTARIO_CRRC = reverbcycle.NR_SEQ_REVERBCYCLE_RCRC)'))
                //onde os recados pertencerem apenas a pessoa
                ->where("reverbcycle.NR_SEQ_CADASTRO_RCRC = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("DT_CADASTRO_RCRC DESC")
                ->group("NR_SEQ_REVERBCYCLE_RCRC")
                ->limit($size, $start);
        }
        //crio a lista
        $cycles = $model_cycle->fetchAll($select_cycle);

        if ($info) {
            $cycles = array(
                'TOTAL_ITEMS'   => (int) $cycles[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $cycles = $cycles->toArray();
        }

        //crio o json
        $this->_helper->json($cycles);
    }


        /**
     * Função responsavel por listas os videos do detalhe do me
     */
    public function listapostsperfilAction() {
        $info  = (bool) $this->_request->getParam("info", false);
        $start = (int)  $this->_request->getParam("start", 0);
        $size  = (int)  $this->_request->getParam("size", 3);

       //pego o perfil do usuário
        $idusuario = $this->_request->getParam("idperfil");
        //inicio o model de blog
        $model_post = new Default_Model_Reverbmeblog();

        if ($info) {
            //crio o select de post
            $select_post = $model_post
                ->select()
                ->from('me_blog', 'COUNT(*) AS TOTAL')
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $idusuario)
                 ->group("idme_blog");
        } else {
            //crio o select de post
            $select_post = $model_post
                ->select()
                //onde os recados pertencerem apenas a pessoa
                ->where("idusuario = ?", $idusuario)
                //ordena pela data do post do maior para menos
                ->order("data_publicacao DESC")
                 ->group("idme_blog")
                ->limit($size, $start);
        }
        //crio a lista
        $posts = $model_post->fetchAll($select_post);

        if ($info) {
            $posts = array(
                'TOTAL_ITEMS'   => (int) $posts[0]['TOTAL'],
                'ITEMS_BY_PAGE' => $size
            );
        } else {
            $posts = $posts->toArray();
        }

        //crio o json
        $this->_helper->json($posts);
    }

    /**
    * Função responsável por fazer a busca auto complete no perfil do amigo
    **/

    public function autocompleteperfilAction(){
        //recebo a palavra chave
        $filter = $this->_request->getParam("filter", "");
        //recebo o id do perfil
        $idperfil = $this->_request->getParam("idperfil");

        //inicio a sessao do usuario
        $usuarios = new Zend_Session_Namespace("usuarios");
        // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        //crio a query
        $select_amigos = "SELECT DS_NOME_CASO
                                 FROM me_friends,
                                      cadastros
                                 WHERE NR_SEQ_AMIGO_FRRC    = NR_SEQ_CADASTRO_CASO AND
                                       NR_SEQ_CADASTRO_FRRC = $idperfil";
        if($filter){
            $select_amigos .= " AND DS_NOME_CASO LIKE " . $db->quote("%" . $filter . "%")." ";
        }
         $select_amigos .= " GROUP BY NR_SEQ_CADASTRO_CASO

                                ORDER BY DT_ACESSO_CASO DESC
                                LIMIT 50";


        // Monta a query
        $query = $db->query($select_amigos);
        //crio uma lista de amigos
        $lista_amigos = $query->fetchAll();

        // recupera apenas os titulos
        foreach ($lista_amigos as $key => $value) {
            //assino o valor de nome
            $json_value[$key] = $value['DS_NOME_CASO'];
        }

        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value,0,13);

        //assino ao view o resultado
        $this->_helper->json($json_value);

    }

    /*
    *
    * Função autocomplete sidebar
    *
    */

    public function autocompletesidebarAction(){
                // Desabilita o layout
       //recebo a palavra chave
        $filter = $this->_request->getParam("filter", "");


       // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        $select_produtos = "SELECT DS_PRODUTO_PRRC
                                 FROM produtos

                                 WHERE
                                  DS_PRODUTO_PRRC LIKE " . $db->quote("%" . $filter . "%")."
                                  GROUP BY NR_SEQ_PRODUTO_PRRC

                                  ORDER BY DS_PRODUTO_PRRC DESC
                                  LIMIT 50";


        // Monta a query
        $query = $db->query($select_produtos);
        //crio uma lista de amigos
        $lista_produtos = $query->fetchAll();

        // recupera apenas os titulos
        foreach ($lista_produtos as $key => $value) {
            //assino o valor de nome
            $json_value[$key] = $value['DS_PRODUTO_PRRC'];
        }

        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value,0,13);

        //assino ao view o resultado
        $this->_helper->json($json_value);

    }

    /*
    *
    * autocomplete do blog
    *
    */

     public function autocompleteblogAction(){
                // Desabilita o layout
       //recebo a palavra chave
        $filter = $this->_request->getParam("filter", "");


       // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        $select = "SELECT DS_TITULO_BLRC
                                 FROM blog

                                 WHERE
                                  DS_TITULO_BLRC LIKE " . $db->quote("%" . $filter . "%")."
                                  GROUP BY NR_SEQ_BLOG_BLRC

                                  ORDER BY DS_TITULO_BLRC DESC
                                  LIMIT 50";


        // Monta a query
        $query = $db->query($select);
        //crio uma lista de amigos
        $lista = $query->fetchAll();

        // recupera apenas os titulos
        foreach ($lista as $key => $value) {
            //assino o valor de nome
            $json_value[$key] = $value['DS_TITULO_BLRC'];
        }

        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value,0,13);

        //assino ao view o resultado
        $this->_helper->json($json_value);

    }


    /*
    *
    * autocomplete do forum
    *
    */

     public function autocompleteforumAction(){
                // Desabilita o layout
       //recebo a palavra chave
        $filter = $this->_request->getParam("filter", "");


       // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        $select = "SELECT DS_TOPICO_TOSO
                                 FROM topicos

                                 WHERE
                                  DS_TOPICO_TOSO LIKE " . $db->quote("%" . $filter . "%")."
                                  GROUP BY NR_SEQ_TOPICO_TOSO

                                  ORDER BY DS_TOPICO_TOSO DESC
                                  LIMIT 50";


        // Monta a query
        $query = $db->query($select);
        //crio uma lista de amigos
        $lista = $query->fetchAll();

        // recupera apenas os titulos
        foreach ($lista as $key => $value) {
            //assino o valor de nome
            $json_value[$key] = $value['DS_TOPICO_TOSO'];
        }

        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value,0,13);

        //assino ao view o resultado
        $this->_helper->json($json_value);

    }


    /*
    *
    * autocomplete do Enquete
    *
    */

     public function autocompleteenqueteAction(){
                // Desabilita o layout
       //recebo a palavra chave
        $filter = $this->_request->getParam("filter", "");


       // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        $select = "SELECT titulo_enquete
                                 FROM enquetes

                                 WHERE
                                  titulo_enquete LIKE " . $db->quote("%" . $filter . "%")."
                                  GROUP BY idenquete

                                  ORDER BY titulo_enquete DESC
                                  LIMIT 50";


        // Monta a query
        $query = $db->query($select);
        //crio uma lista de amigos
        $lista = $query->fetchAll();

        // recupera apenas os titulos
        foreach ($lista as $key => $value) {
            //assino o valor de nome
            $json_value[$key] = $value['titulo_enquete'];
        }

        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value,0,13);

        //assino ao view o resultado
        $this->_helper->json($json_value);

    }


    /*
    *
    * autocomplete do Imprensa
    *
    */

     public function autocompleteimprensaAction(){
                // Desabilita o layout
       //recebo a palavra chave
        $filter = $this->_request->getParam("filter", "");


       // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        $select = "SELECT titulo
                                 FROM imprensa

                                 WHERE
                                  titulo LIKE " . $db->quote("%" . $filter . "%")."
                                  GROUP BY idimprensa

                                  ORDER BY titulo DESC
                                  LIMIT 50";


        // Monta a query
        $query = $db->query($select);
        //crio uma lista de amigos
        $lista = $query->fetchAll();

        // recupera apenas os titulos
        foreach ($lista as $key => $value) {
            //assino o valor de nome
            $json_value[$key] = $value['titulo'];
        }

        // remove duplicados
        $json_value = array_unique($json_value);

        // retorno os 10 primeiros dentro de um único array
        $json_value = array_slice($json_value,0,13);

        //assino ao view o resultado
        $this->_helper->json($json_value);

    }

    /*
    *
    * json de ver mais no blog
    *
    */

    public function vermaistopicosAction(){
       // Cria o objeto de conexão
        $db = Zend_Registry::get("db");

        //crio a query
        $select = "SELECT   NR_SEQ_TOPICO_TOSO,
                            DS_TOPICO_TOSO,
                            DT_CADASTRO_TOSO
                                 FROM topicos

                                 
                                  ORDER BY DT_CADASTRO_TOSO DESC
                                  LIMIT 20";


        // Monta a query
        $query = $db->query($select);
        //crio uma lista de amigos
        $lista = $query->fetchAll();
      
        //assino ao view o resultado
        $this->_helper->json($lista);

    }
    
    public function buscaCepAction(){
        $dados = $this->_request->getParams();

        $idCache = "busca_cep_json_" . $dados['cep'];
        $json = Zend_Registry::get("cache")->load($idCache);
//$json = false;
        if(!$json){

//            $json = file_get_contents("http://cep.republicavirtual.com.br/web_cep.php?cep=" . $dados['cep'] . "&formato=json");
//            $json = json_decode($json, true);

            $json = @file_get_contents('http://viacep.com.br/ws/' . $dados['cep'] . '/json/');
            $json = json_decode($json, true);
            $json['cidade'] = $json['localidade'];
            $json['tipo_logradouro'] = '';
            $json['resultado'] = 1;
            Zend_Registry::get("cache")->save($json, $idCache);
        }

        header('Content-Type: application/json');
        //echo $json; exit;
        $this->_helper->json($json);
    }
}

