wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
  title: "Are You Paying Attention?",
  icon: "smiley",
  category: "common",
  edit: function () {
    return (
      <article>
        <p>Hello, this is a paragraph.</p>
        <h4>Hi there</h4>
      </article>
    )
  },
  save: function () {
    return (
      <>
        <h3>On the frontend.</h3>
        <h5>On the frontend.</h5>
      </>
    )
  }
})
