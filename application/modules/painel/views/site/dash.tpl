
        <div class="container-body">
            <header class="fw lt bs" id="container-top">
                <div class="fw lt" id="top-menu">
                    <button class="rt bs fs13 top-btns" id="logout-btn"></button>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Log Out</a>
                    <a href="#Logout" class="rt anchor fs13 top-btns"> Ir para o site</a>
                </div>
                <div class="fw lt fs12" id="dash-crumb">
                    Usuário &gt; Home
                </div>
                <div id="header-section-name">
                	HOME
                </div>
            </header>
            <div class="lt bs posr" id="dash-body">
            	<div class="lt gw bs pedidos-graph posr graph-blocks">
            		<div class="graph-titles">PEDIDOS</div>
            		<div class="wrap-pedidos-graph-choise"></div>
            		<div class="graph-body graph-type-1">
            			<div class="graph-datas cvs">
            				<ul class="datas-list">
            					{foreach from=$dadosPedidos item=item key=key name=name}
            					<li class="datas-items nl">
            						<input type="hidden" name="{$item['data']}" value="{$item['pedidos']}">
            					</li>
            					{/foreach}
            				</ul>
            			</div>
            		</div>
            		<ul class="pedidos-infos nm np">
            			<li class="pedidos-infos-items nl bs lt posr">
            				<div class="dash-graph-note-label-1">PEDIDOS</div>
            				<div class="dash-graph-note-value-1">1232</div>
            			</li>
            			<li class="pedidos-infos-items nl bs lt posr hbrd">
            				<div class="dash-graph-note-label-1">CONFIRMADOS</div>
            				<div class="dash-graph-note-value-1">980</div>
            			</li>
            			<li class="pedidos-infos-items nl bs lt posr hbrd">
            				<div class="dash-graph-note-label-1">CANCELADOS</div>
            				<div class="dash-graph-note-value-1">132</div>
            			</li>
            			<li class="pedidos-infos-items nl bs lt posr hbrd">
            				<div class="dash-graph-note-label-1">TICKET MÉDIO</div>
            				<div class="dash-graph-note-value-1">2,32</div>
            			</li>
            			<li class="pedidos-infos-items nl bs lt posr hbrd">
            				<div class="dash-graph-note-label-1">MÉDIAS ITENS</div>
            				<div class="dash-graph-note-value-1">1,32</div>
            			</li>
            		</ul>
            	</div>

            	<div class="rt lw bs cadastros-graph posr graph-blocks">
            		<div class="graph-titles">CADASTROS</div>
            		<div class="graph-body graph-type-2">
            			<div class="graph-datas blocks">
            				<ul class="datas-list">
            					{foreach from=$dadosCadastrados item=item key=key name=name}
            					<li class="datas-items nl">
            						<input type="hidden" name="{$item['data']}" value="{$item['compras']}" data-second="{$item['cadastrados']}">
            					</li>
            					{/foreach}
            				</ul>
            			</div>
            		</div>
            	</div>

            	<div class="lt gw bs aniversariantes-graph posr graph-blocks">
            		<div class="graph-titles">ANIVERSARIANTES</div>
            		<div class="aniversariantes-dados">
            			<div class="aniversariantes-blocks first">
            				<div class="dash-graph-note-label-1"> TOTAL </div>
            				<div class="dash-graph-note-value-1"> 90 </div>
            			</div>
            			<div class="aniversariantes-blocks middle">
            				<div class="dash-graph-note-label-1"> COMPRAS</div>
            				<div class="dash-graph-note-value-1"> 90 </div>
            			</div>
            			<div class="aniversariantes-blocks">
            				<div class="dash-graph-note-label-1"> TOTAL R$</div>
            				<div class="dash-graph-note-value-1"> 9.999 </div>
            			</div>
            		</div>
            		<div class="graph-body graph-type-3">
            			<div class="graph-datas">
            				<div class="cake-icon"></div>
            				<canvas class="cake-cvs" width="100" height="100"></canvas>
            				<span class="cake-cvs-title">32%</span>
            				<input type="hidden" class="cake-cvs-val" value="32">
            				<div class="cake-legend">
            					% ANIVERSARIANTES QUE COMPRARAM
            				</div>
            			</div>
            		</div>
            	</div>

            	<div class="rt lw bs vendas-graph posr graph-blocks">
            		<div class="graph-titles">MAIS VENDIDAS</div>
            		<ul class="vendas-infos-lists fw nm np posr lt">
            			<li class="vendas-items-items fw lt">
            				<div class="vendas-item-nome bs lt">Nome do Produto</div>
            				<div class="vendas-item-qntd bs rt">3212</div>
            			</li>
            			<li class="vendas-items-items fw lt">
            				<div class="vendas-item-nome bs lt">Nome do Produto de Teste </div>
            				<div class="vendas-item-qntd bs rt">3212</div>
            			</li>
            			<li class="vendas-items-items fw lt">
            				<div class="vendas-item-nome bs lt">Nome do Produto</div>
            				<div class="vendas-item-qntd bs rt">3212</div>
            			</li>
            			<li class="vendas-items-items fw lt">
            				<div class="vendas-item-nome bs lt">Nome do Produto</div>
            				<div class="vendas-item-qntd bs rt">3212</div>
            			</li>
            			<li class="vendas-items-items fw lt">
            				<div class="vendas-item-nome bs lt">Nome do Produto</div>
            				<div class="vendas-item-qntd bs rt">3212</div>
            			</li>
            		</ul>
            	</div>

            	<div class="fw lt acessos-graph posr graph-blocks">
            		<div class="graph-titles">ACESSOS</div>

            		<div class="gw lt acesso-graphs">
            			<canvas id="access-1" width="537" height="170"></canvas>
            		</div>

            		<div class="lw rt hardware-graphs">

            			<div id="hardware-phone" class="hardware-datas first posr">
            				<div class="access-icons acces-2-icons"></div>
            				<input type="hidden" class="mobiles-cvs-val" value="32">
            				<span class="cvs-title">32%</span>
							<canvas class="mobiles-cvs" width="100" height="100"></canvas>
            				<div class="access-legend">
            					ACESSOS DESKTOP PERÍODO
            				</div>
            			</div>

            			<div id="hardware-desktop" class="hardware-datas posrs">
            				<div class="access-icons acces-3-icons"></div>
            				<input type="hidden" class="desktops-cvs-val" value="62">
            				<span class="cvs-title">62%</span>
							<canvas class="desktops-cvs" width="100" height="100"></canvas>
            				<div class="access-legend">
            					ACESSOS DESKTOP PERÍODO
            				</div>
            			</div>
            		</div>
            	</div>

            </div>
        </div>