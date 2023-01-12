document.addEventListener("DOMContentLoaded", (() => {
	const t = document.getElementById("carousel-style-1");
	if (t) {
		new Glide(t, {
			direction: (() => "rtl" == document.dir ? "rtl" : "ltr")(),
			type: "carousel",
			perView: 4,
			gap: 20,
			breakpoints: {
				640: {
					perView: 1
				},
				768: {
					perView: 2
				}
			}
		}).mount()
	}
	const e = document.getElementById("ckeditor");
	e && ClassicEditor.create(e);
	let o = null;
	if (o = document.getElementById("sortable-style-1"), o) {
		Sortable.create(o, {
			animation: 150
		})
	}
	if (o = document.getElementById("sortable-style-2"), o) {
		Sortable.create(o, {
			handle: ".handle",
			animation: 150
		})
	}
	if (o = document.getElementById("sortable-style-3"), o) {
		Sortable.create(o, {
			animation: 150
		})
	}
}));
const on = (t, e, o, r) => {
		const a = document.querySelectorAll(t);
		for (element of a) element.addEventListener(e, (t => {
			t.target.closest(o) && r(t)
		}))
	},
	animateCSS = (t, e, o = "animate__") => new Promise(((r, a) => {
		const i = `${o}${e}`,
			n = t;
		n.classList.add(`${o}animated`, `${o}faster`, i);
		n.addEventListener("animationend", (t => {
			t.stopPropagation(), n.classList.remove(`${o}animated`, `${o}faster`, i), r("Animation Ended.")
		}), {
			once: !0
		})
	}));
let viewportWidth;
const setViewportWidth = () => {
		viewportWidth = window.innerWidth || document.documentElement.clientWidth
	},
	watchWidth = () => {
		const t = document.querySelector(".menu-bar");
		if (viewportWidth < 640) {
			if (!t) return;
			t.querySelector(".menu-detail.open") || (t.classList.add("menu-hidden"), document.documentElement.classList.add("menu-hidden"), t.querySelectorAll(".menu-detail.open").forEach((e => {
				hideOverlay(), t.classList.contains("menu-wide") || e.classList.remove("open")
			})))
		}
		if (viewportWidth > 640) {
			if (!t) return;
			t.classList.remove("menu-hidden"), document.documentElement.classList.remove("menu-hidden")
		}
		viewportWidth > 1024 && (() => {
			const t = document.querySelector(".sidebar");
			t && t.classList.contains("open") && (t.classList.remove("open"), hideOverlay())
		})()
	};
setViewportWidth(), watchWidth(), window.addEventListener("resize", (() => {
	setViewportWidth(), watchWidth()
}), !1);
const openCollapse = (t, e) => {
		t.style.transitionProperty = "height, opacity", t.style.transitionDuration = "200ms", t.style.transitionTimingFunction = "ease-in-out", setTimeout((() => {
			t.style.height = t.scrollHeight + "px", t.style.opacity = 1
		}), 200), t.addEventListener("transitionend", (() => {
			t.classList.add("open"), t.style.removeProperty("height"), t.style.removeProperty("opacity"), t.style.removeProperty("transition-property"), t.style.removeProperty("transition-duration"), t.style.removeProperty("transition-timing-function"), "function" == typeof e && e()
		}), {
			once: !0
		})
	},
	closeCollapse = (t, e) => {
		t.style.overflowY = "hidden", t.style.height = t.scrollHeight + "px", t.style.transitionProperty = "height, opacity", t.style.transitionDuration = "200ms", t.style.transitionTimingFunction = "ease-in-out", setTimeout((() => {
			t.style.height = 0, t.style.opacity = 0
		}), 200), t.addEventListener("transitionend", (() => {
			t.classList.remove("open"), t.style.removeProperty("overflow-y"), t.style.removeProperty("height"), t.style.removeProperty("opacity"), t.style.removeProperty("transition-property"), t.style.removeProperty("transition-duration"), t.style.removeProperty("transition-timing-function"), "function" == typeof e && e()
		}), {
			once: !0
		})
	},
	alerts = () => {
		on(".alert", "click", '[data-dismiss="alert"]', (t => {
			(t => {
				t.style.overflowY = "hidden", t.style.height = t.offsetHeight + "px", animateCSS(t, "fadeOut").then((() => {
					t.style.transitionProperty = "height, margin, padding, border, opacity", t.style.transitionDuration = "200ms", t.style.transitionTimingFunction = "linear", t.style.opacity = 0, t.style.height = 0, t.style.marginTop = 0, t.style.marginBottom = 0, t.style.paddingTop = 0, t.style.paddingBottom = 0, t.style.border = 0
				})), t.addEventListener("transitionend", (() => {
					t.parentNode && t.parentNode.removeChild(t)
				}), {
					once: !0
				})
			})(t.target.closest(".alert"))
		}))
	};
alerts();
const cards = () => {
	on("body", "click", '[data-toggle="cardSelection"]', (t => {
		(t => {
			t.target.closest(".card").classList.toggle("card_selected")
		})(t)
	}));
	on("body", "click", '[data-toggle="rowSelection"]', (t => {
		(t => {
			t.target.closest("tr").classList.toggle("row_selected")
		})(t)
	}))
};
cards();
const collapse = () => {
	const t = '[data-toggle="collapse"]';
	on("body", "click", t, (e => {
		(e => {
			e.classList.toggle("active"), document.querySelectorAll(e.dataset.target).forEach((t => {
				t.classList.contains("open") ? closeCollapse(t) : openCollapse(t)
			}));
			const o = e.closest(".accordion");
			o && (o.querySelectorAll(t).forEach((t => {
				t !== e && t.classList.remove("active")
			})), o.querySelectorAll(".collapse").forEach((t => {
				t.classList.contains("open") && closeCollapse(t)
			})))
		})(e.target.closest(t))
	}))
};
collapse();
const customizer = () => {
	const t = document.documentElement,
		e = document.querySelector(".menu-bar"),
		o = () => {
			const o = document.getElementById("customizer");
			if (o) {
				const r = localStorage.getItem("scheme"),
					a = o.querySelector('[data-toggle="dark-mode"]');
				a.checked = !!r;
				const i = localStorage.getItem("dir");
				if (i) {
					document.dir = i;
					const t = o.querySelector('[data-toggle="rtl"]');
					t.checked = "rtl" === i
				}
				let n = localStorage.getItem("brandedMenu");
				const s = o.querySelector('[data-toggle="branded-menu"]');
				n && e ? (t.classList.add("menu_branded"), e.classList.add("menu_branded"), s.checked = !0) : s.checked = !1;
				let d = localStorage.getItem("menuType");
				d = d ? d.replace("menu-", "") : "default";
				o.querySelector("[data-value='" + d + "']").checked = !0;
				let l, c = localStorage.getItem("theme");
				c ? (t.classList.add("theme-" + c), l = o.querySelector("[data-toggle='theme'][data-value='" + c + "']")) : l = o.querySelector("[data-toggle='theme'][data-value='default']"), l && l.classList.add("active");
				let p, m = localStorage.getItem("gray");
				m ? (t.classList.add("gray-" + m), p = o.querySelector("[data-toggle='gray'][data-value='" + m + "']")) : p = o.querySelector("[data-toggle='gray'][data-value='default']"), p && p.classList.add("active");
				let g, u = localStorage.getItem("font");
				u ? (t.classList.add("font-" + u), g = o.querySelector("[data-toggle='font'][data-value='" + u + "']")) : g = o.querySelector("[data-toggle='font'][data-value='default']"), g && g.classList.add("active")
			}
		};
	on("#customizer", "click", '[data-toggle="dark-mode"]', (() => {
		document.getElementById("darkModeToggler").click()
	})), on("#customizer", "click", '[data-toggle="rtl"]', (() => {
		"ltr" === document.dir ? (document.dir = "rtl", localStorage.setItem("dir", "rtl")) : (document.dir = "ltr", localStorage.setItem("dir", "ltr"))
	})), on("#customizer", "click", '[data-toggle="branded-menu"]', (() => {
		e && (t.classList.contains("menu_branded") ? (t.classList.remove("menu_branded"), e.classList.remove("menu_branded"), localStorage.removeItem("brandedMenu")) : (t.classList.add("menu_branded"), e.classList.add("menu_branded"), localStorage.setItem("brandedMenu", "menu_branded")))
	})), on("#customizer", "click", '[data-toggle="theme"]', (e => {
		(e => {
			document.getElementById("customizer").querySelectorAll("[data-toggle='theme']").forEach((t => {
				t.classList.remove("active")
			})), e.classList.add("active");
			const o = e.dataset.value;
			t.classList.forEach((e => {
				e.startsWith("theme-") && t.classList.remove(e)
			})), "default" == o ? localStorage.removeItem("theme") : (t.classList.add("theme-" + o), localStorage.setItem("theme", o));
			const r = new Event("ThemeChanged");
			document.dispatchEvent(r)
		})(e.target.closest("[data-toggle='theme']"))
	})), on("#customizer", "click", '[data-toggle="gray"]', (e => {
		(e => {
			document.getElementById("customizer").querySelectorAll("[data-toggle='gray']").forEach((t => {
				t.classList.remove("active")
			})), e.classList.add("active");
			const o = e.dataset.value;
			t.classList.forEach((e => {
				e.startsWith("gray-") && t.classList.remove(e)
			})), "default" == o ? localStorage.removeItem("gray") : (t.classList.add("gray-" + o), localStorage.setItem("gray", o));
			const r = new Event("ThemeChanged");
			document.dispatchEvent(r)
		})(e.target.closest("[data-toggle='gray']"))
	})), on("#customizer", "click", '[data-toggle="font"]', (e => {
		(e => {
			document.getElementById("customizer").querySelectorAll("[data-toggle='font']").forEach((t => {
				t.classList.remove("active")
			})), e.classList.add("active");
			const o = e.dataset.value;
			t.classList.forEach((e => {
				e.startsWith("font-") && t.classList.remove(e)
			})), "default" == o ? localStorage.removeItem("font") : (t.classList.add("font-" + o), localStorage.setItem("font", o));
			const r = new Event("ThemeChanged");
			document.dispatchEvent(r), location.reload()
		})(e.target.closest("[data-toggle='font']"))
	})), on("#customizer", "click", '[data-toggle="customizer"]', (() => {
		(() => {
			const t = document.getElementById("customizer");
			t.classList.contains("open") ? t.classList.remove("open") : (o(), t.classList.add("open"))
		})()
	})), o()
};
customizer();
const darkMode = () => {
	const t = document.documentElement,
		e = localStorage.getItem("scheme");
	e && t.classList.add(e);
	const o = document.getElementById("darkModeToggler");
	if (!o) return;
	"dark" === e && (o.checked = "checked");
	on("body", "change", "#darkModeToggler", (() => {
		t.classList.contains("dark") ? (t.classList.remove("dark"), t.classList.add("light"), localStorage.removeItem("scheme")) : (t.classList.remove("light"), t.classList.add("dark"), localStorage.setItem("scheme", "dark"))
	}))
};
if (darkMode(), "undefined" != typeof Chart) {
	let t = {},
		e = {};
	const o = getComputedStyle(document.body);
	t.primary = o.getPropertyValue("--color-primary"), t.text = o.getPropertyValue("--color-text-normal"), e.body = o.getPropertyValue("--font-body"), document.addEventListener("ThemeChanged", (() => {
		t.primary = o.getPropertyValue("--color-primary")
	}));
	const r = {
		backgroundColor: "white",
		borderColor: "rgb(" + t.primary + ")",
		borderWidth: .5,
		bodyColor: "rgb(" + t.text + ")",
		bodySpacing: 8,
		cornerRadius: 4,
		padding: 16,
		titleColor: "rgb(" + t.primary + ")"
	};
	Chart.defaults.color = "rgb(" + t.text + ")", Chart.defaults.font.family = e.body;
	class a extends Chart.elements.LineElement {
		draw(t) {
			const e = t.stroke;
			t.stroke = function() {
				t.save(), t.shadowColor = "rgba(0, 0, 0, 0.25)", t.shadowBlur = 8, t.shadowOffsetX = 0, t.shadowOffsetY = 4, e.apply(this, arguments), t.restore()
			}, Chart.elements.LineElement.prototype.draw.apply(this, arguments)
		}
	}
	a.id = "lineWithShadowElement", Chart.register(a);
	class i extends Chart.controllers.line {}
	i.id = "lineWithShadow", i.defaults = {
		datasetElementType: "lineWithShadowElement"
	}, Chart.register(i);
	class n extends Chart.controllers.bar {
		draw(t) {
			const e = this.chart.ctx;
			Chart.controllers.bar.prototype.draw.call(this, t), e.save(), e.shadowColor = "rgba(0, 0, 0, 0.25)", e.shadowBlur = 8, e.shadowOffsetX = 0, e.shadowOffsetY = 4, Chart.controllers.bar.prototype.draw.apply(this, arguments), e.restore()
		}
	}
	n.id = "barWithShadow", Chart.register(n);
	class s extends Chart.controllers.pie {}
	s.id = "pieWithShadow", s.defaults = {
		datasetElementType: "lineWithShadowElement"
	}, Chart.register(s);
	class d extends Chart.controllers.doughnut {}
	d.id = "doughnutWithShadow", d.defaults = {
		datasetElementType: "lineWithShadowElement"
	}, Chart.register(d);
	class l extends Chart.controllers.radar {}
	l.id = "radarWithShadow", l.defaults = {
		datasetElementType: "lineWithShadowElement"
	}, Chart.register(l);
	class c extends Chart.controllers.polarArea {}
	c.id = "polarAreaWithShadow", c.defaults = {
		datasetElementType: "lineWithShadowElement"
	}, Chart.register(c);
	class p extends Chart.controllers.line {
		draw(e) {
			const o = this.chart.ctx;
			if (Chart.controllers.line.prototype.draw.call(this, e), this.chart.tooltip._active && this.chart.tooltip._active.length) {
				const e = this.chart.tooltip._active[0].element.x,
					r = this.chart.scales.y.top,
					a = this.chart.scales.y.bottom;
				o.save(), o.beginPath(), o.moveTo(e, r), o.lineTo(e, a), o.lineWidth = 1, o.strokeStyle = "rgb(" + t.primary + "/ .25)", o.stroke(), o.restore()
			}
		}
	}
	p.id = "lineWithAnnotation", Chart.register(p);
	class m extends Chart.controllers.line {
		draw(e) {
			const o = this.chart.ctx;
			if (Chart.controllers.line.prototype.draw.call(this, e), this.chart.tooltip._active && this.chart.tooltip._active.length) {
				const e = this.chart.tooltip._active[0].element.x,
					r = this.chart.scales.y.top,
					a = this.chart.scales.y.bottom;
				o.save(), o.beginPath(), o.moveTo(e, r), o.lineTo(e, a), o.lineWidth = 1, o.strokeStyle = "rgb(" + t.primary + "/ .25)", o.stroke(), o.restore()
			}
		}
	}
	m.id = "lineWithAnnotationAndShadow", m.defaults = {
		datasetElementType: "lineWithShadowElement"
	}, Chart.register(m);
	let g = "";
	if (g = document.getElementById("visitorsChart"), g) {
		g = g.getContext("2d");
		let e = g.createLinearGradient(0, 0, 0, 450);
		e.addColorStop(0, "rgb(" + t.primary + "/ .5)"), e.addColorStop(.75, "rgb(" + t.primary + "/ 0)");
		var visitorsChart = new Chart(g, {
			type: "lineWithShadow",
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
				datasets: [{
					data: [6.25, 7.5, 10, 7.5, 10, 12.5, 10, 12.5, 10, 12.5, 15, 16.25],
					backgroundColor: "rgb(" + t.primary + "/ .1)",
					borderColor: "rgb(" + t.primary + ")",
					borderWidth: 2,
					fill: !0,
					pointBackgroundColor: "white",
					pointBorderColor: "rgb(" + t.primary + ")",
					pointBorderWidth: 2,
					pointRadius: 4,
					pointHoverBackgroundColor: "rgb(" + t.primary + ")",
					pointHoverBorderColor: "white",
					pointHoverBorderWidth: 2,
					pointHoverRadius: 6,
					tension: .5
				}]
			},
			options: {
				plugins: {
					legend: {
						display: !1
					},
					tooltip: r
				},
				scales: {
					y: {
						grid: {
							display: !0,
							drawBorder: !1,
							color: "rgb(" + t.primary + "/ .25)"
						},
						min: 0,
						max: 20,
						ticks: {
							stepSize: 5
						}
					},
					x: {
						grid: {
							display: !1
						}
					}
				}
			}
		})
	}
	if (document.addEventListener("ThemeChanged", (() => {
			if (visitorsChart) {
				const e = visitorsChart.data.datasets[0];
				e.backgroundColor = "rgb(" + t.primary + "/ .1)", e.borderColor = "rgb(" + t.primary + ")", e.pointBorderColor = "rgb(" + t.primary + ")", e.pointHoverBackgroundColor = "rgb(" + t.primary + ")", visitorsChart.options.plugins.tooltip.borderColor = "rgb(" + t.primary + ")", visitorsChart.options.plugins.tooltip.titleColor = "rgb(" + t.primary + ")", visitorsChart.options.scales.y.grid.color = "rgb(" + t.primary + "/ .25)", visitorsChart.update()
			}
		})), g = document.getElementById("categoriesChart"), g) {
		g.getContext("2d");
		var categoriesChart = new Chart(g, {
			type: "polarAreaWithShadow",
			data: {
				labels: ["Potatoes", "Tomatoes", "Onions"],
				datasets: [{
					data: [25, 10, 15],
					backgroundColor: ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"],
					borderColor: "rgb(" + t.primary + ")",
					borderWidth: 2
				}]
			},
			options: {
				maintainAspectRatio: !1,
				plugins: {
					legend: {
						position: "bottom",
						labels: {
							usePointStyle: !0,
							padding: 20
						}
					},
					tooltip: r
				},
				scales: {
					r: {
						ticks: {
							display: !1
						},
						grid: {
							color: "rgb(" + t.primary + "/ .25)"
						}
					}
				},
				layout: {
					padding: 5
				}
			}
		})
	}
	document.addEventListener("ThemeChanged", (() => {
		if (categoriesChart) {
			const e = categoriesChart.data.datasets[0];
			e.backgroundColor = ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"], e.borderColor = "rgb(" + t.primary + ")", categoriesChart.options.plugins.tooltip.borderColor = "rgb(" + t.primary + ")", categoriesChart.options.plugins.tooltip.titleColor = "rgb(" + t.primary + ")", categoriesChart.options.scales.r.grid.color = "rgb(" + t.primary + "/ .25)", categoriesChart.update()
		}
	})), g = document.getElementById("areaChart"), g && (g.getContext("2d"), new Chart(g, {
		type: "line",
		data: {
			labels: ["January", "February", "March", "April", "May", "June"],
			datasets: [{
				data: [5, 10, 15, 10, 15, 10],
				backgroundColor: "rgb(" + t.primary + "/ .1)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				fill: !0,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverBorderWidth: 2,
				pointHoverRadius: 6,
				tension: .5
			}]
		},
		options: {
			plugins: {
				legend: {
					display: !1
				},
				tooltip: r
			},
			scales: {
				y: {
					grid: {
						display: !0,
						drawBorder: !1
					},
					min: 0,
					max: 20,
					ticks: {
						stepSize: 5
					}
				},
				x: {
					grid: {
						display: !1
					}
				}
			}
		}
	})), g = document.getElementById("areaChartWithShadow"), g && (g.getContext("2d"), new Chart(g, {
		type: "lineWithShadow",
		data: {
			labels: ["January", "February", "March", "April", "May", "June"],
			datasets: [{
				data: [5, 10, 15, 10, 15, 10],
				backgroundColor: "rgb(" + t.primary + "/ .1)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				fill: !0,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverBorderWidth: 2,
				pointHoverRadius: 6,
				tension: .5
			}]
		},
		options: {
			plugins: {
				legend: {
					display: !1
				},
				tooltip: r
			},
			scales: {
				y: {
					grid: {
						display: !0,
						drawBorder: !1
					},
					min: 0,
					max: 20,
					ticks: {
						stepSize: 5
					}
				},
				x: {
					grid: {
						display: !1
					}
				}
			}
		}
	})), g = document.getElementById("barChart"), g && (g.getContext("2d"), new Chart(g, {
		type: "bar",
		data: {
			labels: ["January", "February", "March", "April", "May", "June"],
			datasets: [{
				label: "Potatoes",
				data: [5, 10, 15, 10, 15, 10],
				backgroundColor: "rgb(" + t.primary + "/ .1)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}, {
				label: "Tomatoes",
				data: [7.5, 10, 17.5, 15, 12.5, 5],
				backgroundColor: "rgb(" + t.primary + "/ .5)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}]
		},
		options: {
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			},
			scales: {
				y: {
					grid: {
						display: !0,
						drawBorder: !1
					},
					min: 0,
					max: 20,
					ticks: {
						stepSize: 5
					}
				},
				x: {
					grid: {
						display: !1
					}
				}	
			}
		}
	})), g = document.getElementById("barChartWithShadow"), g && (g.getContext("2d"), new Chart(g, {
		type: "barWithShadow",
		data: {
			labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin"],
			datasets: [{
				label: "Non payé",
				data: [5, 10, 15, 10, 15, 10],
				backgroundColor: "rgb(" + t.primary + "/ .1)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 1
			}, {
				label: "Payé",
				data: [7.5, 10, 17.5, 15, 12.5, 5],
				backgroundColor: "rgb(" + t.success + "/ .5)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 1
			}]
		},
		options: {
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			},
			scales: {
				y: {
					grid: {
						display: !0,
						drawBorder: !1
					},
					min: 0,
					max: 20,
					ticks: {
						stepSize: 5
					}
				},
				x: {
					grid: {
						display: !1
					}
				}
			}
		}
	})), g = document.getElementById("lineChart"), g && (g.getContext("2d"), new Chart(g, {
		type: "line",
		data: {
			labels: ["January", "February", "March", "April", "May", "June"],
			datasets: [{
				data: [5, 10, 15, 10, 15, 10],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 6,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverRadius: 8,
				pointHoverBorderWidth: 2,
				tension: .5
			}]
		},
		options: {
			plugins: {
				legend: {
					display: !1
				},
				tooltip: r
			},
			scales: {
				y: {
					grid: {
						display: !0,
						drawBorder: !1
					},
					min: 0,
					max: 20,
					ticks: {
						stepSize: 5
					}
				},
				x: {
					grid: {
						display: !1
					}
				}
			}
		}
	})), g = document.getElementById("lineChartWithShadow"), g && (g.getContext("2d"), new Chart(g, {
		type: "lineWithShadow",
		data: {
			labels: ["January", "February", "March", "April", "May", "June"],
			datasets: [{
				data: [5, 10, 15, 10, 15, 10],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 6,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverRadius: 8,
				pointHoverBorderWidth: 2,
				tension: .5
			}]
		},
		options: {
			plugins: {
				legend: {
					display: !1
				},
				tooltip: r
			},
			scales: {
				y: {
					grid: {
						display: !0,
						drawBorder: !1
					},
					min: 0,
					max: 20,
					ticks: {
						stepSize: 5
					}
				},
				x: {
					grid: {
						display: !1
					}
				}
			}
		}
	})), g = document.getElementById("pieChart"), g && (g.getContext("2d"), new Chart(g, {
		type: "pie",
		data: {
			labels: ["Potatoes", "Tomatoes", "Onions"],
			datasets: [{
				data: [25, 10, 15],
				backgroundColor: ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}]
		},
		options: {
			maintainAspectRatio: !1,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			}
		}
	})), g = document.getElementById("pieChartWithShadow"), g && (g.getContext("2d"), new Chart(g, {
		type: "pieWithShadow",
		data: {
			labels: ["Potatoes", "Tomatoes", "Onions"],
			datasets: [{
				data: [25, 10, 15],
				backgroundColor: ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}]
		},
		options: {
			maintainAspectRatio: !1,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			}
		}
	})), g = document.getElementById("doughnutChart"), g && (g.getContext("2d"), new Chart(g, {
		type: "doughnut",
		data: {
			labels: ["Potatoes", "Tomatoes", "Onions"],
			datasets: [{
				data: [25, 10, 15],
				backgroundColor: ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}]
		},
		options: {
			maintainAspectRatio: !1,
			cutout: "75%",
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			}
		}
	})), g = document.getElementById("doughnutChartWithShadow"), g && (g.getContext("2d"), new Chart(g, {
		type: "doughnutWithShadow",
		data: {
			labels: ["Potatoes", "Tomatoes", "Onions"],
			datasets: [{
				data: [25, 10, 15],
				backgroundColor: ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}]
		},
		options: {
			maintainAspectRatio: !1,
			cutout: "75%",
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			}
		}
	})), g = document.getElementById("radarChart"), g && (g.getContext("2d"), new Chart(g, {
		type: "radar",
		data: {
			labels: ["Drinks", "Snacks", "Lunch", "Dinner"],
			datasets: [{
				label: "Potatoes",
				data: [25, 25, 25, 25],
				backgroundColor: "rgb(" + t.primary + "/ .1)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				fill: !0,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverBorderWidth: 2,
				pointHoverRadius: 6
			}, {
				label: "Tomatoes",
				data: [15, 15, 0, 15],
				backgroundColor: "rgb(" + t.primary + "/ .25",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				fill: !0,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverBorderWidth: 2,
				pointHoverRadius: 6
			}]
		},
		options: {
			maintainAspectRatio: !1,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			},
			scales: {
				r: {
					max: 30,
					ticks: {
						display: !1
					}
				}
			}
		}
	})), g = document.getElementById("radarChartWithShadow"), g && (g.getContext("2d"), new Chart(g, {
		type: "radarWithShadow",
		data: {
			labels: ["Drinks", "Snacks", "Lunch", "Dinner"],
			datasets: [{
				label: "Potatoes",
				data: [25, 25, 25, 25],
				backgroundColor: "rgb(" + t.primary + "/ .1)",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				fill: !0,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverBorderWidth: 2,
				pointHoverRadius: 6
			}, {
				label: "Tomatoes",
				data: [15, 15, 0, 15],
				backgroundColor: "rgb(" + t.primary + "/ .25",
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				fill: !0,
				pointBackgroundColor: "white",
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 2,
				pointRadius: 4,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverBorderWidth: 2,
				pointHoverRadius: 6
			}]
		},
		options: {
			maintainAspectRatio: !1,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			},
			scales: {
				r: {
					max: 30,
					ticks: {
						display: !1
					}
				}
			}
		}
	})), g = document.getElementById("polarChart"), g && (g.getContext("2d"), new Chart(g, {
		type: "polarArea",
		data: {
			labels: ["Potatoes", "Tomatoes", "Onions"],
			datasets: [{
				data: [25, 10, 15],
				backgroundColor: ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}]
		},
		options: {
			maintainAspectRatio: !1,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			},
			scales: {
				r: {
					ticks: {
						display: !1
					}
				}
			},
			layout: {
				padding: 5
			}
		}
	})), g = document.getElementById("polarChartWithShadow"), g && (g.getContext("2d"), new Chart(g, {
		type: "polarAreaWithShadow",
		data: {
			labels: ["Potatoes", "Tomatoes", "Onions"],
			datasets: [{
				data: [25, 10, 15],
				backgroundColor: ["rgb(" + t.primary + "/ .1)", "rgb(" + t.primary + "/ .5)", "rgb(" + t.primary + "/ .25)"],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2
			}]
		},
		options: {
			maintainAspectRatio: !1,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						usePointStyle: !0,
						padding: 20
					}
				},
				tooltip: r
			},
			scales: {
				r: {
					ticks: {
						display: !1
					}
				}
			},
			layout: {
				padding: 5
			}
		}
	}));
	const u = {
			afterInit: t => {
				const e = t.canvas.parentNode,
					o = t.data.datasets[0].data[0],
					r = t.data.datasets[0].label,
					a = t.data.labels[0];
				e.querySelector(".chart-heading").innerHTML = r, e.querySelector(".chart-value").innerHTML = "$" + o, e.querySelector(".chart-label").innerHTML = a
			}
		},
		y = {
			plugins: {
				legend: {
					display: !1
				},
				tooltip: {
					enabled: !1,
					intersect: !1,
					external: t => {
						const e = t.chart.canvas.parentNode,
							o = t.tooltip.dataPoints[0].formattedValue,
							r = t.tooltip.dataPoints[0].dataset.label,
							a = t.tooltip.dataPoints[0].label;
						e.querySelector(".chart-heading").innerHTML = r, e.querySelector(".chart-value").innerHTML = "$" + o, e.querySelector(".chart-label").innerHTML = a
					}
				}
			},
			scales: {
				y: {
					display: !1
				},
				x: {
					display: !1
				}
			},
			layout: {
				padding: {
					left: 5,
					right: 5,
					top: 10,
					bottom: 10
				}
			}
		};
	if (g = document.getElementById("lineWithAnnotationChart1"), g) {
		g.getContext("2d");
		var lineWithAnnotationChart1 = new Chart(g, {
			type: "lineWithAnnotation",
			plugins: [u],
			data: {
				labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
				datasets: [{
					label: "Total Orders",
					data: [1250, 1300, 1550, 900, 1800, 1100, 1600],
					borderColor: "rgb(" + t.primary + ")",
					borderWidth: 2,
					pointBorderColor: "rgb(" + t.primary + ")",
					pointBorderWidth: 4,
					pointRadius: 2,
					pointHoverBackgroundColor: "rgb(" + t.primary + ")",
					pointHoverBorderColor: "white",
					pointHoverRadius: 2,
					tension: .5
				}]
			},
			options: y
		})
	}
	if (document.addEventListener("ThemeChanged", (() => {
			if (lineWithAnnotationChart1) {
				const e = lineWithAnnotationChart1.data.datasets[0];
				e.borderColor = "rgb(" + t.primary + ")", e.pointBorderColor = "rgb(" + t.primary + ")", e.pointHoverBackgroundColor = "rgb(" + t.primary + ")", lineWithAnnotationChart1.update()
			}
		})), g = document.getElementById("lineWithAnnotationChart2"), g) {
		g.getContext("2d");
		var lineWithAnnotationChart2 = new Chart(g, {
			type: "lineWithAnnotation",
			plugins: [u],
			data: {
				labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
				datasets: [{
					label: "Active Orders",
					data: [100, 125, 75, 125, 100, 75, 75],
					borderColor: "rgb(" + t.primary + ")",
					borderWidth: 2,
					pointBorderColor: "rgb(" + t.primary + ")",
					pointBorderWidth: 4,
					pointRadius: 2,
					pointHoverBackgroundColor: "rgb(" + t.primary + ")",
					pointHoverBorderColor: "white",
					pointHoverRadius: 2,
					tension: .5
				}]
			},
			options: y
		})
	}
	if (document.addEventListener("ThemeChanged", (() => {
			if (lineWithAnnotationChart2) {
				const e = lineWithAnnotationChart2.data.datasets[0];
				e.borderColor = "rgb(" + t.primary + ")", e.pointBorderColor = "rgb(" + t.primary + ")", e.pointHoverBackgroundColor = "rgb(" + t.primary + ")", lineWithAnnotationChart2.update()
			}
		})), g = document.getElementById("lineWithAnnotationChart3"), g) {
		g.getContext("2d");
		var lineWithAnnotationChart3 = new Chart(g, {
			type: "lineWithAnnotation",
			plugins: [u],
			data: {
				labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
				datasets: [{
					label: "Pending Orders",
					data: [300, 300, 600, 700, 600, 300, 300],
					borderColor: "rgb(" + t.primary + ")",
					borderWidth: 2,
					pointBorderColor: "rgb(" + t.primary + ")",
					pointBorderWidth: 4,
					pointRadius: 2,
					pointHoverBackgroundColor: "rgb(" + t.primary + ")",
					pointHoverBorderColor: "white",
					pointHoverRadius: 2,
					tension: .5
				}]
			},
			options: y
		})
	}
	if (document.addEventListener("ThemeChanged", (() => {
			if (lineWithAnnotationChart3) {
				const e = lineWithAnnotationChart3.data.datasets[0];
				e.borderColor = "rgb(" + t.primary + ")", e.pointBorderColor = "rgb(" + t.primary + ")", e.pointHoverBackgroundColor = "rgb(" + t.primary + ")", lineWithAnnotationChart3.update()
			}
		})), g = document.getElementById("lineWithAnnotationChart4"), g) {
		g.getContext("2d");
		var lineWithAnnotationChart4 = new Chart(g, {
			type: "lineWithAnnotation",
			plugins: [u],
			data: {
				labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
				datasets: [{
					label: "Shipped Orders",
					data: [200, 400, 200, 500, 100, 100, 400],
					borderColor: "rgb(" + t.primary + ")",
					borderWidth: 2,
					pointBorderColor: "rgb(" + t.primary + ")",
					pointBorderWidth: 4,
					pointRadius: 2,
					pointHoverBackgroundColor: "rgb(" + t.primary + ")",
					pointHoverBorderColor: "white",
					pointHoverRadius: 2,
					tension: .5
				}]
			},
			options: y
		})
	}
	document.addEventListener("ThemeChanged", (() => {
		if (lineWithAnnotationChart4) {
			const e = lineWithAnnotationChart4.data.datasets[0];
			e.borderColor = "rgb(" + t.primary + ")", e.pointBorderColor = "rgb(" + t.primary + ")", e.pointHoverBackgroundColor = "rgb(" + t.primary + ")", lineWithAnnotationChart4.update()
		}
	})), g = document.getElementById("lineWithAnnotationAndShadowChart1"), g && (g.getContext("2d"), new Chart(g, {
		type: "lineWithAnnotationAndShadow",
		plugins: [u],
		data: {
			labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			datasets: [{
				label: "Total Orders",
				data: [1250, 1300, 1550, 900, 1800, 1100, 1600],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 4,
				pointRadius: 2,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverRadius: 2,
				tension: .5
			}]
		},
		options: y
	})), g = document.getElementById("lineWithAnnotationAndShadowChart2"), g && (g.getContext("2d"), new Chart(g, {
		type: "lineWithAnnotationAndShadow",
		plugins: [u],
		data: {
			labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			datasets: [{
				label: "Active Orders",
				data: [100, 125, 75, 125, 100, 75, 75],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 4,
				pointRadius: 2,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverRadius: 2,
				tension: .5
			}]
		},
		options: y
	})), g = document.getElementById("lineWithAnnotationAndShadowChart3"), g && (g.getContext("2d"), new Chart(g, {
		type: "lineWithAnnotationAndShadow",
		plugins: [u],
		data: {
			labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			datasets: [{
				label: "Pending Orders",
				data: [300, 300, 600, 700, 600, 300, 300],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 4,
				pointRadius: 2,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverRadius: 2,
				tension: .5
			}]
		},
		options: y
	})), g = document.getElementById("lineWithAnnotationAndShadowChart4"), g && (g.getContext("2d"), new Chart(g, {
		type: "lineWithAnnotationAndShadow",
		plugins: [u],
		data: {
			labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			datasets: [{
				label: "Shipped Orders",
				data: [200, 400, 200, 500, 100, 100, 400],
				borderColor: "rgb(" + t.primary + ")",
				borderWidth: 2,
				pointBorderColor: "rgb(" + t.primary + ")",
				pointBorderWidth: 4,
				pointRadius: 2,
				pointHoverBackgroundColor: "rgb(" + t.primary + ")",
				pointHoverBorderColor: "white",
				pointHoverRadius: 2,
				tension: .5
			}]
		},
		options: y
	}))
}
const customFileInput = () => {
	on("body", "change", 'input[type="file"]', (t => {
		const e = t.target.value.split("\\").pop();
		t.target.parentNode.querySelector(".file-name").innerHTML = e
	}))
};
on("body", "change", 'input[type="file"]', (t => {
	const e = t.target.value.split("\\").pop();
	t.target.parentNode.querySelector(".file-name").innerHTML = e
}));
const fullscreen = () => {
	const t = document.getElementById("fullScreenToggler");
	if (!t) return;
	const e = document.documentElement;
	on("body", "click", "#fullScreenToggler", (() => {
		document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement ? document.exitFullscreen ? document.exitFullscreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitExitFullscreen ? document.webkitExitFullscreen() : document.msExitFullscreen && document.msExitFullscreen() : e.requestFullscreen ? e.requestFullscreen() : e.mozRequestFullScreen ? e.mozRequestFullScreen() : e.webkitRequestFullscreen ? e.webkitRequestFullscreen() : e.msRequestFullscreen && e.msRequestFullscreen(), t.classList.contains("la-expand-arrows-alt") ? (t.classList.remove("la-expand-arrows-alt"), t.classList.add("la-compress-arrows-alt")) : (t.classList.remove("la-compress-arrows-alt"), t.classList.add("la-expand-arrows-alt"))
	}))
};
fullscreen();
const menu = () => {
	const t = document.documentElement,
		e = localStorage.getItem("menuType"),
		o = document.querySelector(".menu-bar"),
		r = document.querySelector(".menu-items");
	if (!o) return;
	e && (t.classList.add(e), o.classList.add(e));
	const a = () => {
		o.querySelectorAll(".menu-detail.open").forEach((t => {
			hideOverlay(), o.classList.contains("menu-wide") || t.classList.remove("open")
		}))
	};
	document.addEventListener("click", (t => {
		t.target.closest(".menu-items a") || t.target.closest(".menu-detail") || o.classList.contains("menu-wide") || a()
	})), on(".menu-items", "click", ".link", (t => {
		const e = t.target.closest(".link").dataset.target,
			r = o.querySelector(e);
		if (r && !o.classList.contains("menu-wide")) {
			const t = r.classList.contains("open");
			a(), r && !t ? (showOverlay(!0), r.classList.add("open")) : hideOverlay()
		}
	}));
	on(".top-bar", "click", "[data-toggle='menu']", (e => {
		o.classList.contains("menu-hidden") ? (t.classList.remove("menu-hidden"), o.classList.remove("menu-hidden")) : (t.classList.add("menu-hidden"), o.classList.add("menu-hidden"))
	}));
	const i = e => {
			const r = o.querySelector(".menu-detail.open");
			switch (t.classList.remove("menu-icon-only"), o.classList.remove("menu-icon-only"), t.classList.remove("menu-wide"), o.classList.remove("menu-wide"), s(), t.classList.remove("menu-hidden"), o.classList.remove("menu-hidden"), e) {
				case "icon-only":
					t.classList.add("menu-icon-only"), o.classList.add("menu-icon-only"), localStorage.setItem("menuType", "menu-icon-only"), r && showOverlay(!0);
					break;
				case "wide":
					t.classList.add("menu-wide"), o.classList.add("menu-wide"), localStorage.setItem("menuType", "menu-wide"), n(), r && hideOverlay();
					break;
				case "hidden":
					t.classList.add("menu-hidden"), o.classList.add("menu-hidden"), localStorage.setItem("menuType", "menu-hidden"), a();
					break;
				default:
					localStorage.removeItem("menuType"), r && showOverlay(!0)
			}
		},
		n = () => {
			o.querySelector(".menu-header").classList.remove("hidden"), o.querySelectorAll(".menu-items .link").forEach((t => {
				const e = t.dataset.target,
					r = o.querySelector(".menu-detail" + e);
				r && (r.classList.add("collapse"), t.setAttribute("data-toggle", "collapse"), t.after(r))
			}))
		},
		s = () => {
			t.classList.remove("menu-wide"), o.classList.remove("menu-wide"), o.querySelector(".menu-header").classList.add("hidden"), o.querySelectorAll(".menu-items .link").forEach((t => {
				const e = t.dataset.target,
					a = o.querySelector(".menu-detail" + e);
				a && (a.classList.remove("collapse"), t.removeAttribute("data-toggle", "collapse"), r.after(a))
			}))
		};
	o.classList.contains("menu-wide") && n(), on(".menu-bar", "click", "[data-toggle='menu-type']", (t => {
		const e = t.target.closest("[data-toggle='menu-type']").dataset.value;
		i(e)
	})), on("#customizer", "click", "[data-toggle='menu-type']", (t => {
		const e = t.target.closest("[data-toggle='menu-type']").dataset.value;
		i(e)
	}))
};
menu();
const showActivePage = () => {
	const t = window.location.href.split(/[?#]/)[0],
		e = document.querySelectorAll(".menu-bar a");
	e && e.forEach((e => {
		if (e.href === t) {
			e.classList.add("active");
			const t = e.closest(".menu-detail");
			if (!t) return;
			document.querySelector('.menu-items .link[data-target="[data-menu=' + t.dataset.menu + ']"]').classList.add("active")
		}
	}))
};
showActivePage();
const modal = () => {
	const t = '[data-toggle="modal"]';
	on("body", "click", t, (o => {
		const r = o.target.closest(t);
		(t => {
			showOverlay(), t.classList.add("active");
			const o = t.dataset.animations.split(", ")[0],
				r = t.querySelector(".modal-content");
			animateCSS(r, o), t.addEventListener("click", (o => {
				void 0 === t.dataset.staticBackdrop && t === o.target && e(t)
			}))
		})(document.querySelector(r.dataset.target))
	}));
	const e = t => {
		hideOverlay();
		const e = t.dataset.animations.split(", ")[1],
			o = t.querySelector(".modal-content");
		animateCSS(o, e).then((() => {
			t.classList.remove("active")
		}))
	};
	on(".modal", "click", '[data-dismiss="modal"]', (t => {
		const o = t.target.closest(".modal");
		e(o)
	}))
};
modal();
const showOverlay = t => {
		if (document.querySelector(".overlay")) return;
		document.body.classList.add("overlay-show");
		const e = document.createElement("div");
		t ? e.setAttribute("class", "overlay overlay_workspace") : e.setAttribute("class", "overlay"), document.body.appendChild(e), e.classList.add("active")
	},
	hideOverlay = () => {
		overlayToRemove = document.querySelector(".overlay"), overlayToRemove && (document.body.classList.remove("overlay-show"), overlayToRemove.classList.remove("active"), document.body.removeChild(overlayToRemove))
	},
	ratingStars = () => {
		rateStars = t => {
			const e = t.target.closest(".rating-stars"),
				o = Array.from(e.children);
			let r = 0;
			r = o.length - o.indexOf(t.target), o.forEach((t => t.classList.remove("active"))), t.target.classList.add("active"), console.log("You have rated " + r + " stars.")
		}, on("body", "click", ".rating-stars", (t => {
			rateStars(t)
		}))
	};
rateStars = t => {
	const e = t.target.closest(".rating-stars"),
		o = Array.from(e.children);
	let r = 0;
	r = o.length - o.indexOf(t.target), o.forEach((t => t.classList.remove("active"))), t.target.classList.add("active"), console.log("You have rated " + r + " stars.")
}, on("body", "click", ".rating-stars", (t => {
	rateStars(t)
}));
const showPassword = () => {
	on("body", "click", '[data-toggle="password-visibility"]', (t => {
		(t => {
			const e = t.closest(".form-control-addon-within").querySelector("input");
			"password" === e.type ? (e.type = "text", t.classList.remove("text-gray-600", "dark:text-gray-600"), t.classList.add("text-primary", "dark:text-primary")) : (e.type = "password", t.classList.remove("text-primary", "dark:text-primary"), t.classList.add("text-gray-600", "dark:text-gray-600"))
		})(t.target.closest('[data-toggle="password-visibility"]'))
	}))
};
on("body", "click", '[data-toggle="password-visibility"]', (t => {
	(t => {
		const e = t.closest(".form-control-addon-within").querySelector("input");
		"password" === e.type ? (e.type = "text", t.classList.remove("text-gray-600", "dark:text-gray-600"), t.classList.add("text-primary", "dark:text-primary")) : (e.type = "password", t.classList.remove("text-primary", "dark:text-primary"), t.classList.add("text-gray-600", "dark:text-gray-600"))
	})(t.target.closest('[data-toggle="password-visibility"]'))
}));
const sidebar = () => {
	on("body", "click", '[data-toggle="sidebar"]', (() => {
		(() => {
			const t = document.querySelector(".sidebar:not(.sidebar_customizer)");
			t.classList.contains("open") ? (t.classList.remove("open"), hideOverlay()) : (t.classList.add("open"), showOverlay(!0))
		})()
	}))
};
sidebar();
const tabs = () => {
	let t = !1;
	on("body", "click", '[data-toggle="tab"]', (e => {
		const o = e.target.closest('[data-toggle="tab"]'),
			r = o.closest(".tabs"),
			a = r.querySelector(".tab-nav .active"),
			i = r.querySelector(".collapse.open"),
			n = r.querySelector(o.dataset.target);
		t || a !== o && (a.classList.remove("active"), o.classList.add("active"), t = !0, closeCollapse(i, (() => {
			openCollapse(n, (() => {
				t = !1
			}))
		})))
	})), on("body", "click", '[data-toggle="wizard"]', (t => {
		const e = t.target.closest(".wizard"),
			o = t.target.dataset.direction,
			r = e.querySelectorAll(".nav-link"),
			a = e.querySelector(".nav-link.active");
		let i = 0;
		switch (r.forEach(((t, e) => {
			t === a && (i = e)
		})), o) {
			case "next":
				r[i + 1] && r[i + 1].click();
				break;
			case "previous":
				r[i - 1] && r[i - 1].click()
		}
	}))
};
tabs();
const customTippy = () => {
	tippy.delegate("body", {
		target: '.menu-icon-only [data-toggle="tooltip-menu"]',
		touch: ["hold", 500],
		theme: "light-border tooltip",
		offset: [0, 12],
		interactive: !0,
		animation: "scale",
		placement: "right",
		appendTo: () => document.body
	}), tippy('[data-toggle="tooltip"]', {
		theme: "light-border tooltip",
		touch: ["hold", 500],
		offset: [0, 12],
		interactive: !0,
		animation: "scale",
		appendTo: () => document.body
	}), tippy('[data-toggle="popover"]', {
		theme: "light-border popover",
		offset: [0, 12],
		interactive: !0,
		allowHTML: !0,
		trigger: "click",
		animation: "shift-toward-extreme",
		content: t => "<h5>" + t.dataset.popoverTitle + '</h5><div class="mt-5">' + t.dataset.popoverContent + "</div>",
		appendTo: () => document.body
	}), tippy('[data-toggle="dropdown-menu"]', {
		theme: "light-border",
		offset: [0, 8],
		arrow: !1,
		placement: "bottom-start",
		interactive: !0,
		allowHTML: !0,
		animation: "shift-toward-extreme",
		content: t => {
			let e = t.closest(".dropdown").querySelector(".dropdown-menu");
			return e = e.outerHTML, e
		},
		appendTo: () => document.body
	}), tippy('[data-toggle="custom-dropdown-menu"]', {
		theme: "light-border",
		offset: [0, 8],
		arrow: !1,
		placement: "bottom-start",
		interactive: !0,
		allowHTML: !0,
		animation: "shift-toward-extreme",
		content: t => {
			let e = t.closest(".dropdown").querySelector(".custom-dropdown-menu");
			return e = e.outerHTML, e
		},
		appendTo: () => document.body
	}), tippy('[data-toggle="search-select"]', {
		theme: "light-border",
		offset: [0, 8],
		maxWidth: "none",
		arrow: !1,
		placement: "bottom-start",
		trigger: "click",
		interactive: !0,
		allowHTML: !0,
		animation: "shift-toward-extreme",
		content: t => {
			let e = t.closest(".search-select").querySelector(".search-select-menu");
			return e = e.outerHTML, e
		},
		appendTo: t => t.closest(".search-select")
	})
};
tippy.delegate("body", {
	target: '.menu-icon-only [data-toggle="tooltip-menu"]',
	touch: ["hold", 500],
	theme: "light-border tooltip",
	offset: [0, 12],
	interactive: !0,
	animation: "scale",
	placement: "right",
	appendTo: () => document.body
}), tippy('[data-toggle="tooltip"]', {
	theme: "light-border tooltip",
	touch: ["hold", 500],
	offset: [0, 12],
	interactive: !0,
	animation: "scale",
	appendTo: () => document.body
}), tippy('[data-toggle="popover"]', {
	theme: "light-border popover",
	offset: [0, 12],
	interactive: !0,
	allowHTML: !0,
	trigger: "click",
	animation: "shift-toward-extreme",
	content: t => "<h5>" + t.dataset.popoverTitle + '</h5><div class="mt-5">' + t.dataset.popoverContent + "</div>",
	appendTo: () => document.body
}), tippy('[data-toggle="dropdown-menu"]', {
	theme: "light-border",
	offset: [0, 8],
	arrow: !1,
	placement: "bottom-start",
	interactive: !0,
	allowHTML: !0,
	animation: "shift-toward-extreme",
	content: t => {
		let e = t.closest(".dropdown").querySelector(".dropdown-menu");
		return e = e.outerHTML, e
	},
	appendTo: () => document.body
}), tippy('[data-toggle="custom-dropdown-menu"]', {
	theme: "light-border",
	offset: [0, 8],
	arrow: !1,
	placement: "bottom-start",
	interactive: !0,
	allowHTML: !0,
	animation: "shift-toward-extreme",
	content: t => {
		let e = t.closest(".dropdown").querySelector(".custom-dropdown-menu");
		return e = e.outerHTML, e
	},
	appendTo: () => document.body
}), tippy('[data-toggle="search-select"]', {
	theme: "light-border",
	offset: [0, 8],
	maxWidth: "none",
	arrow: !1,
	placement: "bottom-start",
	trigger: "click",
	interactive: !0,
	allowHTML: !0,
	animation: "shift-toward-extreme",
	content: t => {
		let e = t.closest(".search-select").querySelector(".search-select-menu");
		return e = e.outerHTML, e
	},
	appendTo: t => t.closest(".search-select")
});
const toasts = () => {
	const t = document.getElementById("toasts-container");
	on("body", "click", '[data-toggle="toast"]', (e => {
		(e => {
			const o = e.dataset.title,
				r = e.dataset.content;
			let a = '<div class="toast mb-5"><div class="toast-header"><h5>' + o + "</h5><small>" + e.dataset.time + '</small><button type="button" class="close" data-dismiss="toast">&times</button></div><div class="toast-body">' + r + "</div></div>";
			a = (new DOMParser).parseFromString(a, "text/html").body.firstChild, t.appendChild(a), animateCSS(a, "fadeInUp")
		})(e.target)
	}));
	on("body", "click", '[data-dismiss="toast"]', (t => {
		(t => {
			t.style.overflowY = "hidden", t.style.height = t.offsetHeight + "px", animateCSS(t, "fadeOutUp").then((() => {
				t.style.transitionProperty = "height, margin, padding, border, opacity", t.style.transitionDuration = "200ms", t.style.transitionTimingFunction = "linear", t.style.opacity = 0, t.style.height = 0, t.style.marginTop = 0, t.style.marginBottom = 0, t.style.paddingTop = 0, t.style.paddingBottom = 0, t.style.border = 0
			})), t.addEventListener("transitionend", (() => {
				t.parentNode && t.parentNode.removeChild(t)
			}), {
				once: !0
			})
		})(t.target.closest(".toast"))
	}))
};
toasts();