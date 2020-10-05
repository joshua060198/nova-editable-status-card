Nova.booting((Vue, router, store) => {
    Vue.component(
        "editable-status-card",
        require("./components/EditableStatusCard")
    );
});
