const Icon = (props) => {
    return(

        <div 
        dangerouslySetInnerHTML={{__html: props.icon}}
        style={{display:"flex", alignItems:"center"}}
        />
    )
}

export default Icon;