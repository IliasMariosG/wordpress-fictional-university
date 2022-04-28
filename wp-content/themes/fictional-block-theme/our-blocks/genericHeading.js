wp.blocks.registerBlockType("ourblocktheme/genericheading", {
  title: "Generic Heading",
  edit: EditComponent,
  save: SaveComponent
})

function EditComponent(params) {
  return (
    <div>Hello</div>
  )
}

function SaveComponent(params) {
  return (
   <div>This is our heading.</div>
  )
}