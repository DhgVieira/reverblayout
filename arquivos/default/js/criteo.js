var criteo = {
	setCriteoList: function(setEmail, setSiteType) {
		window.criteo_q = window.criteo_q || [];
		window.criteo_q.push(
			{ event: "setAccount", account: 28203 },
			{ event: "setEmail", email: setEmail },
			{ event: "setSiteType", type: setSiteType },
			{ event: "viewList", item: reverb.getProdutosID()}
		);
	},
	getCriteoHome: function(setEmail, setSiteType) {
		window.criteo_q = window.criteo_q || [];
		window.criteo_q.push(
			{ event: "setAccount", account: 28203 },
			{ event: "setEmail", email: setEmail },
			{ event: "setSiteType", type: setSiteType },
			{ event: "viewHome" }
		);
	},
	setCriteoProduct: function(setEmail, setSiteType) {
		window.criteo_q = window.criteo_q || [];
		window.criteo_q.push(
			{ event: "setAccount", account: 28203 },
			{ event: "setEmail", email: setEmail },
			{ event: "setSiteType", type: setSiteType },
			{ event: "viewItem", item: getProdutoID }
		);
	}
};